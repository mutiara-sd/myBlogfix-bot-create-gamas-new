<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Meeting;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Store a newly created agenda in storage.
     */
    public function store(Request $request, Meeting $meeting)
    {
        $validated = $request->validate([
            'agenda_text' => 'required|string|max:1000',
        ]);

        // Explicitly set meeting_id
        Agenda::create([
            'meeting_id' => $meeting->id,
            'agenda_text' => $validated['agenda_text'],
        ]);

        return back()->with('success', 'Agenda berhasil ditambahkan.');
    }

    /**
     * Update the specified agenda in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'agenda_text' => 'required|string|max:1000',
        ]);

        $agenda->update($validated);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Remove the specified agenda from storage.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        
        return back()->with('success', 'Agenda berhasil dihapus.');
    }
}