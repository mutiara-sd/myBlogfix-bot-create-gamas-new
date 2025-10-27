<div>
    <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
            <label class="me-2 mb-0">Show</label>
            <select wire:model.live="page" class="form-select form-select-sm w-auto">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <label class="ms-2 mb-0">entries</label>
        </div>
    </div>
    <div class="table-responsive d-flex">
        <table class="table table-bordered table-striped">
            <thead class="font-size-11 text-center">
                <tr>
                    <th>NO</th>
                    @foreach ($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td>{{ $data->firstItem() + $index }}</td>
                        @foreach ($headers as $header)
                            <td>{{ $item[$header] ?? '-' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>            
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-2 px-5">
        <div>
            <p class="mb-0">Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} results</p>
        </div>
        <div>
            {{ $data->links('pagination::bootstrap-4') }}
        </div>      
    </div>    
</div>