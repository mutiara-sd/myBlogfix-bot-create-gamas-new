<x-layout>
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h1 style="margin-bottom: 20px; color: #333;">
            <i class="fas fa-calendar-plus"></i> Create New Meeting
        </h1>
        
        @if ($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; border-left: 4px solid #dc3545;">
                <strong>Please fix the following errors:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('warning'))
            <div style="background: #fff3cd; color: #856404; padding: 15px; margin-bottom: 20px; border-radius: 4px; border-left: 4px solid #ffc107;">
                {{ session('warning') }}
            </div>
        @endif

        <form action="{{ route('meetings.store') }}" method="POST" style="space-y: 20px;">
            @csrf
            
            <div style="margin-bottom: 20px;">
                <label for="project_id" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">
                    Project <span style="color: red;">*</span>
                </label>
                <select name="project_id" id="project_id" required
                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; background: white;">
                    <option value="">-- Select Project --</option>
                    @forelse($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @empty
                        <option value="" disabled>No projects available</option>
                    @endforelse
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="title" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">
                    Meeting Title <span style="color: red;">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px;"
                       placeholder="Enter meeting title">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="scheduled_at" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">
                    Date & Time <span style="color: red;">*</span>
                </label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}" required
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px;">
            </div>

            <div style="margin-bottom: 30px;">
                <label for="location" style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">
                    Location
                </label>
                <input type="text" name="location" id="location" value="{{ old('location') }}"
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px;"
                       placeholder="Meeting room or online">
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" 
                        style="background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: bold;">
                    <i class="fas fa-save"></i> Create Meeting
                </button>
                <a href="{{ route('meetings.index') }}" 
                   style="background: #6c757d; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-size: 16px; font-weight: bold;">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
</x-layout>