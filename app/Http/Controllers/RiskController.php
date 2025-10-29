<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\Meeting;
use Illuminate\Http\Request;

class RiskController extends Controller
{
    public function store(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'risk_title' => 'required|string|max:255',
            'mitigation' => 'nullable|string|max:1000',
            'owner' => 'nullable|string|max:100',
        ]);

        Risk::create([
            'meeting_id' => $meeting->id,
            'risk_title' => $validated['risk_title'],
            'mitigation' => $validated['mitigation'] ?? null,
            'owner' => $validated['owner'] ?? null,
        ]);

        return back()->with('success', 'Risk berhasil ditambahkan.');
    }

    public function destroy(Risk $risk)
    {
        $risk->delete();
        
        return back()->with('success', 'Risk berhasil dihapus.');
    }
}