<?php

namespace App\Http\Controllers;

use App\Models\MinuteDecision;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MinuteDecisionController extends Controller
{
    /**
     * Store a newly created decision in storage.
     */
    public function store(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'decision_text' => 'required|string|max:1000',
        ]);

        // Explicitly set meeting_id
        MinuteDecision::create([
            'meeting_id' => $meeting->id,
            'decision_text' => $validated['decision_text'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Decision berhasil ditambahkan.');
    }

    /**
     * Update the specified decision in storage.
     */
    public function update(Request $request, MinuteDecision $decision)
    {
        $validated = $request->validate([
            'decision_text' => 'required|string|max:1000',
            'status' => 'nullable|in:pending,approved,rejected,completed',
        ]);

        $decision->update($validated);

        return back()->with('success', 'Decision berhasil diperbarui.');
    }

    /**
     * Remove the specified decision from storage.
     */
    public function destroy(MinuteDecision $decision)
    {
        $decision->delete();
        
        return back()->with('success', 'Decision berhasil dihapus.');
    }
}