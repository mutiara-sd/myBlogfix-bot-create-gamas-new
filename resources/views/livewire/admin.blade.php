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
    <div class="d-flex align-items-center">
      <label class="me-2 mb-0">Search:</label>
      <input type="text" wire:model.live.debounce.300ms="search" class="form-control form-control-sm me-2"
        placeholder="Search User" />
      <label class="me-2 mb-0">Filter</label>
      <select wire:model.live="role" class="form-select form-select-sm w-auto">
        <option value="">All Roles</option>
        <option value="Admin">Admin</option>
        <option value="Assurance">Assurance</option>
        <option value="WiFi">WiFi</option>
        <option value="HO">HO</option>
        <option value="SDV">SDV</option>
        <option value="Bges">Bges</option>
        <option value="Fullfilment">Fullfilment</option>
        <option value="Public">Public</option>
      </select>
    </div>
  </div>
  <div class="table-responsive d-flex">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th class="text-center">NO</th>
          @foreach (['name', 'username', 'telegram_username', 'role'] as $field)
            <th class="text-center">
              <a href="#" wire:click.prevent="sortBy('{{ $field }}')">
                {{ ucfirst(str_replace('_', ' ', $field)) }}
                @if ($sort === $field)
                  <i class="fas fa-sort-{{ $direction === 'asc' ? 'up' : 'down' }}"></i>
                @else
                  <i class="fas fa-sort"></i>
                @endif
              </a>
            </th>
          @endforeach
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $index => $user)
          <tr>
            <td class="text-center">{{ $users->firstItem() + $index }}</td>
            <td class="text-center">{{ $user->name }}</td>
            <td class="text-center">{{ $user->username }}</td>
            <td class="text-center">{{ $user->telegram_username }}</td>
            <td class="text-center">{{ $user->role_name }}</td>
            <td class="text-center">
              <button type="button" wire:click="verify({{ $user->id }})" class="btn btn-primary">Verify</button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">User not found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
    <div>
      {{ $users->links() }}
    </div>
  </div>
</div>
