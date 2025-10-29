<!-- Agenda Section -->
<div class="notulen-group" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h5 style="margin: 0; color: #4b5563; font-weight: 600;">
            <i style="color: #8b5cf6; margin-right: 8px;"></i>
            Agenda
        </h5>
        <button type="button" class="btn-add-item" 
            onclick="toggleAgendaForm({{ $meeting->id }})" 
            style="background: #8b5cf6; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-plus"></i> Add Agenda
        </button>
    </div>

    <!-- Form Add Agenda -->
    <div id="agendaForm-{{ $meeting->id }}" style="display: none; margin-bottom: 20px; background: #f9fafb; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <form action="{{ route('agendas.store', $meeting->id) }}" method="POST" style="display: flex; gap: 10px;">
            @csrf
            <input type="text" name="agenda_text" placeholder="Enter agenda item..." required 
                style="flex: 1; border: 2px solid #e5e7eb; border-radius: 8px; padding: 10px 14px; font-size: 14px; transition: border 0.3s;">
            <button type="submit" style="background: #8b5cf6; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                Save
            </button>
            <button type="button" onclick="toggleAgendaForm({{ $meeting->id }})" 
                style="background: #6b7280; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                Cancel
            </button>
        </form>
    </div>

    <!-- List Agenda -->
    @if ($meeting->agendas->count() > 0)
        <div style="background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border-left: 4px solid #8b5cf6; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            @foreach ($meeting->agendas as $index => $agenda)
                <div class="agenda-item" style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px; padding: 15px; background: white; border-radius: 10px; border: 1px solid #e5e7eb; transition: all 0.3s;">
                    <span style="color: #8b5cf6; font-weight: 700; min-width: 30px; font-size: 16px;">{{ $index + 1 }}.</span>
                    <span style="flex: 1; color: #374151; line-height: 1.6;">{{ $agenda->agenda_text }}</span>
                    <form action="{{ route('agendas.destroy', $agenda->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this agenda item?')" 
                            style="background: rgba(239, 68, 68, 0.1); border: none; color: #ef4444; cursor: pointer; padding: 6px 10px; border-radius: 6px; transition: all 0.3s;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 50px 20px; background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border-radius: 12px; border: 2px dashed #d1d5db;">
            <i class="fas fa-list-ul" style="font-size: 48px; color: #d1d5db; margin-bottom: 12px;"></i>
            <p style="color: #9ca3af; font-size: 15px; margin: 0;">Belum ada agenda</p>
        </div>
    @endif
</div>

<!-- Decisions Section -->
<div class="notulen-group" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h5 style="margin: 0; color: #4b5563; font-weight: 600;">
            <i style="color: #3b82f6; margin-right: 8px;"></i>
            Decisions
        </h5>
    </div>

    <!-- Form Add Decision -->
    <form action="{{ route('decisions.store', $meeting->id) }}" method="POST" 
        style="display: flex; gap: 10px; margin-bottom: 20px; background: #f9fafb; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        @csrf
        <input type="text" name="decision_text" placeholder="Add decision..." required 
            style="flex: 1; border: 2px solid #e5e7eb; border-radius: 8px; padding: 10px 14px; font-size: 14px; transition: border 0.3s;">
        <button type="submit" 
            style="background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus"></i> Add
        </button>
    </form>

    <!-- List Decisions -->
    @forelse ($meeting->minuteDecisions as $decision)
        <div class="decision-item" style="display: flex; align-items: center; gap: 12px; padding: 15px; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%); border-radius: 10px; margin-bottom: 12px; border-left: 4px solid #3b82f6; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: all 0.3s;">
            <div style="width: 20px; height: 20px; border-radius: 50%; background: #3b82f6; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-check" style="color: white; font-size: 10px;"></i>
            </div>
            <span style="color: #374151; flex: 1; line-height: 1.6;">{{ $decision->decision_text }}</span>
            <!-- @if($decision->status)
                <span style="color: #059669; font-size: 12px; background: rgba(16,185,129,0.15); padding: 4px 12px; border-radius: 20px; font-weight: 600;">
                    {{ ucfirst($decision->status) }}
                </span>
            @endif -->
            <form action="{{ route('decisions.destroy', $decision->id) }}" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete this decision?')" 
                    style="background: rgba(239, 68, 68, 0.1); border: none; color: #ef4444; cursor: pointer; padding: 6px 10px; border-radius: 6px; transition: all 0.3s;">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    @empty
        <div style="text-align: center; padding: 50px 20px; background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%); border-radius: 12px; border: 2px dashed #d1d5db;">
            <i class="fas fa-clipboard-list" style="font-size: 48px; color: #d1d5db; margin-bottom: 12px;"></i>
            <p style="color: #9ca3af; font-size: 15px; margin: 0;">No decisions recorded yet.</p>
        </div>
    @endforelse
</div>

<!-- Risks Section -->
<div class="notulen-group" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h5 style="margin: 0; color: #4b5563; font-weight: 600;">Risks</h5>
        <button type="button" class="btn-add-risk" 
            onclick="toggleRiskForm({{ $meeting->id }})" 
            style="background: #f59e0b; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; transition: all 0.3s;">
            <i class="fas fa-plus"></i> Add Risk
        </button>
    </div>

    <!-- Form Add Risk -->
    <div id="riskForm-{{ $meeting->id }}" style="display: none; margin-bottom: 20px; background: #fef3c7; padding: 20px; border-radius: 12px; border: 1px solid #fbbf24;">
        <form action="{{ route('risks.store', $meeting->id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 12px;">
                <input type="text" name="risk_title" placeholder="Risk title (e.g., Server downtime)..." required 
                    style="width: 100%; border: 2px solid #f59e0b; border-radius: 8px; padding: 10px 14px; font-size: 13px;">
            </div>
            <div style="margin-bottom: 12px;">
                <input type="text" name="owner" placeholder="Owner (e.g., @user)" 
                    style="width: 100%; border: 2px solid #f59e0b; border-radius: 8px; padding: 10px 14px; font-size: 13px;">
            </div>
            <div style="margin-bottom: 12px;">
                <input type="text" name="mitigation" placeholder="Mitigation plan..." 
                    style="width: 100%; border: 2px solid #f59e0b; border-radius: 8px; padding: 10px 14px; font-size: 13px;">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <button type="submit" style="background: #f59e0b; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 12px;">
                    Save
                </button>
                <button type="button" onclick="toggleRiskForm({{ $meeting->id }})" 
                    style="background: #6b7280; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 12px;">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- List Risks -->
    @if ($meeting->risks->count() > 0)
        <div id="riskItems" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            @foreach ($meeting->risks as $risk)
                <div class="risk-item" style="background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; position: relative; padding-right: 40px;">
                    <!-- Tombol Delete (Pindah ke Atas) -->
                    <form action="{{ route('risks.destroy', $risk->id) }}" method="POST" 
                        style="position: absolute; top: 12px; right: 12px; margin: 0;" 
                        onsubmit="return confirm('Delete this risk?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            style="background: rgba(239, 68, 68, 0.1); border: none; color: #ef4444; cursor: pointer; padding: 6px 8px; border-radius: 6px; transition: all 0.3s;"
                            onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.2)'" 
                            onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.1)'">
                            <i class="fas fa-trash" style="font-size: 12px;"></i>
                        </button>
                    </form>
                    
                    <!-- Risk Title -->
                    <div style="margin-bottom: 10px; padding-right: 5px;">
                        <span style="font-weight: 600; color: #374151; font-size: 14px; line-height: 1.4; display: block; word-wrap: break-word;">
                            {{ $risk->risk_title }}
                        </span>
                    </div>
                    
                    <!-- Owner -->
                    @if($risk->owner)
                        <div style="margin-bottom: 8px;">
                            <span style="font-size: 12px; color: #6b7280;">Owner:</span>
                            <span style="background: #3b82f6; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; margin-left: 5px;">
                                {{ $risk->owner }}
                            </span>
                        </div>
                    @endif
                    
                    <!-- Mitigation -->
                    @if($risk->mitigation)
                        <div style="font-size: 12px; color: #6b7280; line-height: 1.5; word-wrap: break-word;">
                            <strong>Mitigation:</strong> {{ $risk->mitigation }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div id="riskItems" style="text-align: center; padding: 40px 20px; background: #f9fafb; border-radius: 8px; border: 2px dashed #e5e7eb;">
            <i class="fas fa-exclamation-triangle" style="font-size: 36px; color: #d1d5db; margin-bottom: 10px;"></i>
            <p style="color: #9ca3af; font-size: 14px; margin: 0;">No risks identified yet</p>
        </div>
    @endif
</div>

<script>
    function toggleAgendaForm(meetingId) {
        const form = document.getElementById('agendaForm-' + meetingId);
        if (form) {
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }
    }

    function toggleRiskForm(meetingId) {
        const form = document.getElementById('riskForm-' + meetingId);
        if (form) {
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }
    }
</script>