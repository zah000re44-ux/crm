<?php

// app/Http/Controllers/BuildingController.php
namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::withCount('units')->latest()->paginate(12);
        return view('buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('buildings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'district' => ['nullable','string','max:255'],
            'address' => ['nullable','string','max:255'],
        ]);

        $building = Building::create($data);

        return redirect()->route('buildings.show', $building)->with('success', 'تم إضافة المبنى');
    }

    public function show(Building $building)
    {
        $building->load(['units' => fn($q) => $q->latest()]);
        return view('buildings.show', compact('building'));
    }
}

