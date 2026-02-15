<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private array $allowedStatuses = [
        'جديد',
        'تم التواصل',
        'معاينة',
        'عرض سعر',
        'تفاوض',
        'تم التعاقد',
        'مغلق - تم',
        'مغلق - ملغي',
    ];

    public function index(Request $request)
    {
        $query = Client::with('assignedTo')->orderBy('id', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('building_name', 'like', "%{$q}%")
                    ->orWhere('district', 'like', "%{$q}%")
                    ->orWhere('building_owner', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $clients = $query->get();
        $agents  = User::where('role', 'agent')->orderBy('name')->get();

        return view('clients.index', compact('clients', 'agents'));
    }

    public function show(Client $client)
    {
        $client->load(['notes', 'contracts']);

        return view('clients.show', compact('client'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['nullable','string','max:50'],
            'email' => ['nullable','email','max:255'],
            'source' => ['nullable','string','max:255'],

            'status' => ['required', 'in:' . implode(',', $this->allowedStatuses)],
            'assigned_to' => ['nullable','exists:users,id'],

            // الحقول العقارية
            'building_name' => ['nullable','string','max:255'],
            'district' => ['nullable','string','max:255'],
            'building_owner' => ['nullable','string','max:255'],
        ]);

        Client::create($data);

        return redirect()->route('clients.index')->with('status', 'تم إضافة العميل بنجاح');
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['nullable','string','max:50'],
            'email' => ['nullable','email','max:255'],
            'source' => ['nullable','string','max:255'],

            'status' => ['required', 'in:' . implode(',', $this->allowedStatuses)],
            'assigned_to' => ['nullable','exists:users,id'],

            // الحقول العقارية
            'building_name' => ['nullable','string','max:255'],
            'district' => ['nullable','string','max:255'],
            'building_owner' => ['nullable','string','max:255'],
        ]);

        $client->update($data);

        return redirect()->route('clients.show', $client)->with('status', 'تم تحديث بيانات العميل');
    }

    public function updateStatus(Request $request, Client $client)
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', $this->allowedStatuses)],
        ]);

        $client->update(['status' => $data['status']]);

        return back()->with('status', 'تم تحديث حالة العميل');
    }

    public function storeNote(Request $request, Client $client)
    {
        $data = $request->validate([
            'type' => ['nullable', 'in:note,call,meeting,whatsapp'],
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $client->notes()->create([
            'user_id' => $request->user()->id,
            'type' => $data['type'] ?? 'note',
            'content' => $data['content'],
        ]);

        return redirect()->route('clients.show', $client)->with('status', 'تمت إضافة المتابعة');
    }
}
