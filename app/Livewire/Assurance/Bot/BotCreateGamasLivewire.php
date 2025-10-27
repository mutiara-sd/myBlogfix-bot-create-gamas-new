<?php

namespace App\Livewire\Assurance\Bot;

use App\Models\Assurance\Bot\BotCreateGamas;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class BotCreateGamasLivewire extends Component
{
    use WithPagination;

    public $page = 10;

    public $tab = 'home';

    public $sort = 'nama';

    public $direction = 'asc';

    public $startDate;

    public $endDate;

    public $perbaikanList = [];

    public $editingId = null;

    public $tempPerbaikan = '';

    protected $queryString = ['page', 'sort', 'direction'];

    public function pickBotGamas($update)
    {
        $updated = BotCreateGamas::where('update_id', $update)
            ->whereNull('agent_id')
            ->update(['agent_id' => auth()->id()]);

        if ($updated === 0) {
            return redirect('/bot-create-gamas')->with('error', 'Data sudah diambil orang lain');
        } else {
            return redirect('/bot-create-gamas')->with('success', 'Data berhasil diambil');
        }
    }

    public function edit($update)
    {
        $this->editingId = $update;
        $this->tempPerbaikan = $this->perbaikanList[$update] ?? '';
    }

    public function simpanPerbaikan()
    {
        if ($this->editingId) {
            $this->perbaikanList[$this->editingId] = $this->tempPerbaikan;
            $this->editingId = null;
            $this->tempPerbaikan = '';
        }
    }

    public function submitPerbaikan($update)
    {
        if (! isset($this->perbaikanList[$update]) || empty($this->perbaikanList[$update])) {
            $this->addError("perbaikanList.$update", 'Perbaikan belum diisi.');

            return;
        }

        $updated = BotCreateGamas::where('update_id', $update)
            ->where('agent_id', auth()->id())
            ->update(['perbaikan' => $this->perbaikanList[$update]]);

        if ($updated === 0) {
            $this->dispatch('perbaikanGagal');
        } else {
            unset($this->perbaikanList[$update]);
            $this->dispatch('perbaikanBerhasil');
        }
    }

    public function mount()
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $allowed = [
            'nama', 'time_update', 'datek', 'list_alpro',
            'gpon', 'slot_port', 'tiket', 'penyebab', 'estimasi', 'pic',
        ];

        if (! in_array($field, $allowed)) {
            return;
        }

        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function filterDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = match ($this->tab) {
            'home' => BotCreateGamas::homeQuery()->orderBy($this->sort, $this->direction)->paginate($this->page),
            'inbox' => BotCreateGamas::inbox(auth()->user())->orderBy($this->sort, $this->direction)->paginate($this->page),
            'all' => BotCreateGamas::allList(
                Carbon::parse($this->startDate)->format('Ymd'),
                Carbon::parse($this->endDate)->format('Ymd')
            )->orderBy($this->sort, $this->direction)->paginate($this->page),
            default => collect(),
        };

        return view('livewire.assurance.bot.bot-create-gamas-livewire', [
            'items' => $data,
            'tab' => $this->tab,
        ]);
    }
}
