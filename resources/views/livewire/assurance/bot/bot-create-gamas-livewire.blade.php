<div>
  <div class="d-flex gap-2 mb-4">
    <button wire:click="setTab('home')"
      class="btn {{ $tab === 'home' ? 'btn-primary text-white' : 'btn-light' }}">HOME</button>
    <button wire:click="setTab('inbox')" class="btn {{ $tab === 'inbox' ? 'btn-primary text-white' : 'btn-light' }}">MY
      INBOX</button>
    <button wire:click="setTab('all')"
      class="btn {{ $tab === 'all' ? 'btn-primary text-white' : 'btn-light' }}">ALL</button>
  </div>
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
  @if ($tab === 'home')
    <div>
      <h3 class="font-size-16 mb-4">Gamas Distribusi / ODP / Feeder</h3>
      @include('livewire.assurance.bot.partials.table-home')
    </div>
  @endif

  @if ($tab === 'inbox')
    <div>
      <h3 class="font-size-16 mb-4">My Inbox Gamas Distribusi / ODP / Feeder</h3>
      @include('livewire.assurance.bot.partials.table-inbox')
    </div>
  @endif

  @if ($tab === 'all')
    <div>
      <div class="d-sm-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
          <h3 class="font-size-16">UNBIND TELEGRAM ALL</h3>
        </div>
        <div class="d-flex align-items-center">
          <label for="startDate" class="me-2 mb-0">Tanggal</label>
          <input type="date" wire:model="startDate" id="startDate" class="form-control form-control-sm me-2">
          <span class="me-2 mb-0">s/d</span>
          <input type="date" wire:model="endDate" id="endDate" class="form-control form-control-sm me-2">
          <button type="button" wire:click="filterDate" class="btn btn-primary btn-sm me-2">Submit</button>
        </div>
      </div>
      @include('livewire.assurance.bot.partials.table-all')
    </div>
  @endif
  <div>
    {{ $items->links() }}
  </div>
</div>
</div>
@push('scripts')
  <script>
    function refreshFeatherIcons() {
      if (window.feather) {
        feather.replace();
      }
    }
    document.addEventListener("DOMContentLoaded", refreshFeatherIcons);
    const observer = new MutationObserver((mutations) => {
      for (const mutation of mutations) {
        if (mutation.type === "childList") {
          refreshFeatherIcons();
          break;
        }
      }
    });
    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
    Livewire.on('perbaikanBerhasil', () => {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Perbaikan berhasil disimpan!',
        timer: 2000,
        showConfirmButton: false,
      });
    });

    Livewire.on('perbaikanGagal', () => {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Perbaikan gagal disimpan.',
      });
    });
  </script>
@endpush
