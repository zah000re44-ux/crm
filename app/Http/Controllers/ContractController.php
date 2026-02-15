<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Client;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $q = Contract::query()->with(['client','agent'])->latest();

        // agent يشوف عقوده فقط
        if ($user->role === 'agent') {
            $q->where('agent_id', $user->id);
        }

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = trim($request->search);
            $q->where(function ($qq) use ($s) {
                $qq->where('contract_no', 'like', "%{$s}%")
                   ->orWhereHas('client', function ($c) use ($s) {
                       $c->where('name','like',"%{$s}%")
                         ->orWhere('phone','like',"%{$s}%");
                   });
            });
        }

        $contracts = $q->paginate(15)->withQueryString();

        return view('contracts.index', compact('contracts'));
    }

    public function create(Request $request)
    {
        $clients = Client::select('id','name','phone')->get();
        $selectedClient = $request->client_id ?? null;

        return view('contracts.create', compact('clients','selectedClient'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'   => ['required','exists:clients,id'],
            'contract_no' => ['nullable','string','max:50'],
            'status'      => ['required','in:draft,active,completed,cancelled'],
            'starts_at'   => ['required','date'],
            'ends_at'     => ['required','date','after:starts_at'],
            'amount'      => ['required','numeric','min:0'],
            'notes'       => ['nullable','string'],
        ]);

        $data['agent_id'] = $request->user()->id;
        $data['type'] = 'rent';

        $contract = Contract::create($data);

        return redirect()->route('contracts.show', $contract)
                         ->with('success', 'تم إنشاء العقد.');
    }

    public function show(Contract $contract, Request $request)
    {
        if ($request->user()->role === 'agent' && 
            $contract->agent_id !== $request->user()->id) {
            abort(403);
        }

        $contract->load(['client','agent']);

        return view('contracts.show', compact('contract'));
    }
}
