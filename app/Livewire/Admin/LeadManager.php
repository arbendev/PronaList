<?php

namespace App\Livewire\Admin;

use App\Models\Lead;
use App\Models\Property;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $sourceFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    // Edit modal
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $editStatus = '';
    public string $editNotes = '';
    public ?int $editAssignedTo = null;
    public int $editCreditCost = 5;
    public int $editMaxBuyers = 3;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }
    public function updatingSourceFilter(): void { $this->resetPage(); }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function editLead(int $id): void
    {
        $lead = Lead::findOrFail($id);
        $this->editingId = $id;
        $this->editStatus = $lead->status;
        $this->editNotes = $lead->notes ?? '';
        $this->editAssignedTo = $lead->assigned_to;
        $this->editCreditCost = $lead->credit_cost;
        $this->editMaxBuyers = $lead->max_buyers;
        $this->showModal = true;
    }

    public function saveLead(): void
    {
        $this->validate([
            'editCreditCost' => 'required|integer|min:0',
            'editMaxBuyers' => 'required|integer|min:1',
        ]);

        $lead = Lead::findOrFail($this->editingId);
        $lead->update([
            'status' => $this->editStatus,
            'notes' => $this->editNotes ?: null,
            'assigned_to' => $this->editAssignedTo ?: null,
            'assigned_at' => ($this->editAssignedTo && !$lead->assigned_to) ? now() : $lead->assigned_at,
            'credit_cost' => $this->editCreditCost,
            'max_buyers' => $this->editMaxBuyers,
        ]);
        $this->showModal = false;
        $this->editingId = null;
    }

    public function quickStatus(int $id, string $status): void
    {
        Lead::findOrFail($id)->update(['status' => $status]);
    }

    public function deleteLead(int $id): void
    {
        Lead::findOrFail($id)->delete();
    }

    public function exportCsv(): StreamedResponse
    {
        $leads = Lead::with('property', 'assignedAgent')
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        return response()->streamDownload(function () use ($leads) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Source', 'Status', 'Property', 'Assigned To', 'Created']);
            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->id,
                    $lead->name,
                    $lead->email,
                    $lead->phone,
                    $lead->source,
                    $lead->status,
                    $lead->property?->translated_title ?? '—',
                    $lead->assignedAgent?->name ?? '—',
                    $lead->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        }, 'leads-' . date('Y-m-d') . '.csv');
    }

    public function render()
    {
        $query = Lead::with('property', 'assignedAgent');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) $query->where('status', $this->statusFilter);
        if ($this->sourceFilter) $query->where('source', $this->sourceFilter);

        $query->orderBy($this->sortField, $this->sortDirection);

        $leads = $query->paginate(15);

        $stats = [
            'total' => Lead::count(),
            'new' => Lead::where('status', 'new')->count(),
            'unassigned' => Lead::whereNull('assigned_to')->count(),
            'assigned' => Lead::whereNotNull('assigned_to')->count(),
        ];

        $agents = User::where('role', 'agent')->orderBy('name')->get();

        return view('livewire.admin.lead-manager', compact('leads', 'stats', 'agents'))
            ->layout('layouts.admin');
    }
}
