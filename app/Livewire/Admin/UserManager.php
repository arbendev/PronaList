<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';

    // Edit modal
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $editRole = '';
    public bool $editVerified = false;
    public int $creditAmount = 0; // For adding/removing credits in modal

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingRoleFilter(): void { $this->resetPage(); }

    public function changeRole(int $id, string $role): void
    {
        User::findOrFail($id)->update(['role' => $role]);
    }

    public function toggleVerified(int $id): void
    {
        $user = User::findOrFail($id);
        $user->update(['is_verified' => !$user->is_verified]);
    }

    public function editUser(int $id): void
    {
        $user = User::findOrFail($id);
        $this->editingId = $id;
        $this->editRole = $user->role;
        $this->editVerified = $user->is_verified ?? false;
        $this->creditAmount = 0; // Reset
        $this->showModal = true;
    }

    public function addCredits(int $amount): void
    {
        if ($this->editingId && $amount != 0) {
            $user = User::findOrFail($this->editingId);
            $user->addCredits($amount, 'Admin manual adjustment via User Manager');
            $this->creditAmount = 0; // Reset after adding
            $this->dispatch('credits-updated'); // Optional: for UI feedback
        }
    }

    public function saveUser(): void
    {
        $user = User::findOrFail($this->editingId);
        
        $user->update([
            'role' => $this->editRole,
            'is_verified' => $this->editVerified,
        ]);

        // Handle credit adjustment if value is entered
        if ($this->creditAmount != 0) {
            $user->addCredits($this->creditAmount, 'Admin manual adjustment');
        }

        $this->showModal = false;
        $this->editingId = null;
        $this->creditAmount = 0;
    }

    public function deleteUser(int $id): void
    {
        if ($id === auth()->id()) {
            return; // Can't delete yourself
        }
        User::findOrFail($id)->delete();
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        $users = $query->latest()->paginate(15);

        return view('livewire.admin.user-manager', compact('users'))
            ->layout('layouts.admin');
    }
}
