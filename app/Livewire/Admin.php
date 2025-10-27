<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Admin extends Component
{
    use WithPagination;

    public $search = '';

    public $sort = 'name';

    public $direction = 'asc';

    public $role = '';

    public $page = 10;

    protected $queryString = ['search', 'sort', 'direction', 'role', 'page'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }

    public function render()
    {
        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where('is_verified', false)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('users.name', 'like', "%{$this->search}%")
                        ->orWhere('users.username', 'like', "%{$this->search}%")
                        ->orWhere('users.telegram_username', 'like', "%{$this->search}%");
                });
            })
            ->when($this->role, function ($query) {
                $query->where('roles.name', $this->role);
            })
            ->when($this->sort === 'role', function ($query) {
                return $query->orderBy('roles.name', $this->direction);
            }, function ($query) {
                return $query->orderBy("users.{$this->sort}", $this->direction);
            })
            ->select('users.*', 'roles.name as role_name')
            ->paginate($this->page);

        return view('livewire.admin', [
            'users' => $users,
        ]);
    }

    public function verify(User $user)
    {
        $user->update(['is_verified' => true]);

        return redirect('/admin')->with('success', 'User verified successfully.');
    }
}
