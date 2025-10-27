<x-layout>
    <div class="container">
        <h3 class="mb-3">Project List</h3>

        {{-- Alert sukses setelah create --}}
        @if(session('success'))
            <div class="alert alert-success rounded-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm rounded-3">
            <div class="card-body">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Project Code</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Owner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->code }}</td>
                                <td>{{ ucfirst($project->status) }}</td>
                                <td>{{ $project->description }}</td>
                                <td>{{ $project->owner->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No projects found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>