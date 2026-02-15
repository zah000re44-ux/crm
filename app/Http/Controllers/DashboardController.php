<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientNote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalClients = Client::count();

        $clientsByStatus = Client::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $todayNotesByType = ClientNote::selectRaw('type, COUNT(*) as total')
            ->whereDate('created_at', now()->toDateString())
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        $latestClients = Client::latest('id')->take(5)->get();

        $latestNotes = ClientNote::with(['client', 'user'])
            ->latest('id')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalClients',
            'clientsByStatus',
            'todayNotesByType',
            'latestClients',
            'latestNotes'
        ));
    }
}
