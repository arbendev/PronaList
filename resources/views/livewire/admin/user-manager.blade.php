<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="admin-page-title">Users</h1>
        <span class="text-muted">{{ $users->total() }} total</span>
    </div>

    {{-- Filters --}}
    <div class="admin-card mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search name or email...">
            </div>
            <div class="col-md-3">
                <select wire:model.live="roleFilter" class="form-select">
                    <option value="">All Roles</option>
                    <option value="user">User</option>
                    <option value="agent">Agent</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="admin-card">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Credits</th>
                        <th>Verified</th>
                        <th>Properties</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $user->avatar_url }}" alt="" style="width:32px;height:32px;border-radius:50%;object-fit:cover">
                                    <div class="d-flex flex-column" style="line-height:1.2">
                                        <strong style="font-size:0.9rem">{{ $user->name }}</strong>
                                        <span class="text-muted small">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <select wire:change="changeRole({{ $user->id }}, $event.target.value)" class="form-select form-select-sm" style="width:auto" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    @foreach(['user','agent','admin'] as $r)
                                        <option value="{{ $r }}" {{ $user->role === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                @if($user->role === 'agent')
                                    <span class="badge bg-light text-dark border">{{ $user->credits }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="toggleVerified({{ $user->id }})" class="btn btn-sm {{ $user->is_verified ? 'btn-success' : 'btn-outline-secondary' }}">
                                    {{ $user->is_verified ? '✓ Verified' : 'Unverified' }}
                                </button>
                            </td>
                            <td>{{ $user->properties()->count() }}</td>
                            <td style="font-size:0.85rem">{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button wire:click="editUser({{ $user->id }})" class="btn btn-sm btn-outline-primary">Edit</button>
                                    @if($user->id !== auth()->id())
                                        <button wire:click="deleteUser({{ $user->id }})" wire:confirm="Delete this user?" class="btn btn-sm btn-outline-danger">✕</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">No users found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3">{{ $users->links() }}</div>
    </div>

    {{-- Edit Modal --}}
    @if($showModal)
        <div class="admin-modal-overlay" wire:click.self="$set('showModal', false)">
            <div class="admin-modal">
                <div class="admin-modal-header">
                    <h5 class="mb-0">Edit User #{{ $editingId }}</h5>
                    <button wire:click="$set('showModal', false)" class="btn-close"></button>
                </div>
                <div class="admin-modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <select wire:model="editRole" class="form-select">
                            @foreach(['user','agent','admin'] as $r)
                                <option value="{{ $r }}">{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Add Credits (Current: {{ \App\Models\User::find($editingId)->credits }})</label>
                        <div class="input-group">
                            <span class="input-group-text">+</span>
                            <input wire:model="creditAmount" type="number" class="form-control" placeholder="0">
                            <button wire:click="addCredits($wire.creditAmount)" class="btn btn-outline-success" type="button">Add Now</button>
                        </div>
                        <div class="form-text">Enter negative amount to deduct credits. "Add Now" applies immediately.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Verified</label>
                        <div class="form-check form-switch">
                            <input wire:model="editVerified" class="form-check-input" type="checkbox" id="editVerified">
                            <label class="form-check-label" for="editVerified">Mark as verified</label>
                        </div>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button wire:click="$set('showModal', false)" class="btn btn-light">Cancel</button>
                    <button wire:click="saveUser" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    @endif
</div>
