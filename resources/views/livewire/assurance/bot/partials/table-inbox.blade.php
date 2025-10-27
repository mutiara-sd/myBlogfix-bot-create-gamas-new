<div class="table-responsive d-flex">
  <table class="table table-bordered table-striped">
    <thead class="font-size-11 text-center">
      <tr>
        <th>NO</th>
        @php
          $columnMap = [
              'IDENTITAS PEMOHON' => 'nama',
              'JENIS' => 'time_update',
              'DATEK' => 'datek',
              'LIST ALPRO' => 'list_alpro',
              'TIKET' => 'tiket',
              'PENYEBAB' => 'penyebab',
              'ESTIMASI' => 'estimasi',
              'PIC' => 'pic',
          ];
        @endphp
        @foreach (array_keys($columnMap) as $label)
          @php $field = $columnMap[$label]; @endphp
          <th class="text-center">
            <a href="#" wire:click.prevent="sortBy('{{ $field }}')">
              {{ $label }}
              @if ($sort === $field)
                <i class="fas fa-sort-{{ $direction === 'asc' ? 'up' : 'down' }}"></i>
              @else
                <i class="fas fa-sort"></i>
              @endif
            </a>
          </th>
        @endforeach
        <th><i data-feather="edit"></i></th>
        <th><i data-feather="edit"></i>STATUS</th>
        <th>ACTION</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $i => $item)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{!! nl2br(e("Nama: {$item->nama}\nUser Link: @$item->user\nNama/NIK: {$item->nama_nik}")) !!}</td>
          <td>{!! nl2br(e("$item->jenis\n$item->time_update")) !!}</td>
          <td>{{ $item->datek }}</td>
          <td>{{ $item->list_alpro }}</td>
          <td>{{ $item->tiket }}</td>
          <td>{{ $item->penyebab }}</td>
          <td>{{ $item->estimasi }}</td>
          <td>{{ $item->pic }}</td>
          <td>
            <button class="btn btn-primary" wire:click="edit({{ $item->update_id }})" data-bs-toggle="modal"
              data-bs-target="#modalEdit">
              EDIT
            </button>
          </td>
          <td>{{ $item->status }}</td>
          <td>
            <button class="btn btn-primary" wire:click="submitPerbaikan({{ $item->update_id }})">
              SUBMIT
            </button>
          </td>
        </tr>
      @endforeach
    </tbody>
    </tbody>
  </table>
</div>

<div wire:ignore.self class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Edit Perbaikan</h5>
      </div>
      <div class="modal-body">
        <textarea wire:model.defer="tempPerbaikan" class="form-control"></textarea>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" wire:click="simpanPerbaikan" data-bs-dismiss="modal">
          Simpan
        </button>
      </div>
    </div>
  </div>
</div>
