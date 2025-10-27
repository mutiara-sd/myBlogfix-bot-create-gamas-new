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
              'GPON' => 'gpon',
              'SLOT PORT' => 'slot_port',
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
        <th>STATUS</th>
        <th><i data-feather="edit"></i></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $i => $item)
        <tr>
          <td>{{ $items->firstItem() + $i }}</td>
          <td>{!! nl2br(e("Nama: {$item->nama}\nUser Link: @$item->user\nNama/NIK: {$item->nama_nik}")) !!}</td>
          <td>{!! nl2br(e("$item->jenis\n$item->time_update")) !!}</td>
          <td>{{ $item->datek }}</td>
          <td>{{ $item->list_alpro }}</td>
          <td>{{ $item->gpon }}</td>
          <td>{{ $item->slot_port }}</td>
          <td>{{ $item->tiket }}</td>
          <td>{{ $item->penyebab }}</td>
          <td>{{ $item->estimasi }}</td>
          <td>{{ $item->pic }}</td>
          <td>{{ $item->status }}</td>
          <td>
            <button type="button" wire:click='pickBotGamas("{{ $item->update_id }}")' class="btn btn-primary">
              Ambil
            </button>
          </td>
        </tr>
      @endforeach
    </tbody>
    </tbody>
  </table>
</div>
