<?php

namespace App\Livewire;

use App\Models\Lead;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class LeadManager extends Component
{
    use WithPagination;

    public string $filterStatus = '';
    public string $filterSource = '';
    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    // Modal state
    public ?int $editingLeadId = null;
    public string $editNotes = '';
    public string $editStatus = '';
    public ?int $assignAgentId = null;

    protected $queryString = ['filterStatus', 'filterSource', 'search'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingFilterSource(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function openLead(int $id): void
    {
        $lead = Lead::findOrFail($id);
        $this->editingLeadId = $lead->id;
        $this->editNotes = $lead->notes ?? '';
        $this->editStatus = $lead->status;
        $this->assignAgentId = $lead->assigned_to;
    }

    public function closeLead(): void
    {
        $this->editingLeadId = null;
        $this->editNotes = '';
        $this->editStatus = '';
        $this->assignAgentId = null;
    }

    public function updateLead(): void
    {
        $lead = Lead::findOrFail($this->editingLeadId);

        $data = [
            'status' => $this->editStatus,
            'notes' => $this->editNotes ?: null,
        ];

        if ($this->assignAgentId) {
            $data['assigned_to'] = $this->assignAgentId;
            $data['assigned_at'] = now();
            if ($this->editStatus === 'new' || $this->editStatus === 'contacted' || $this->editStatus === 'qualified') {
                $data['status'] = 'assigned';
                $this->editStatus = 'assigned';
            }
        } else {
            $data['assigned_to'] = null;
            $data['assigned_at'] = null;
        }

        $lead->update($data);
        $this->closeLead();
    }

    public function quickStatus(int $id, string $status): void
    {
        Lead::findOrFail($id)->markAs($status);
    }

    public function deleteLead(int $id): void
    {
        Lead::findOrFail($id)->delete();
    }

    public function exportCsv()
    {
        $leads = $this->getFilteredQuery()->get();

        $csv = "ID,Name,Email,Phone,Source,Status,Property,City,Assigned To,Created At,Message,Notes\n";
        foreach ($leads as $lead) {
            $csv .= implode(',', [
                $lead->id,
                '"' . str_replace('"', '""', $lead->name) . '"',
                $lead->email,
                $lead->phone ?? '',
                $lead->source_label,
                $lead->status,
                $lead->property_id ?? '',
                $lead->property?->city ?? '',
                $lead->assignedAgent?->name ?? '',
                $lead->created_at->format('Y-m-d H:i'),
                '"' . str_replace('"', '""', $lead->message) . '"',
                '"' . str_replace('"', '""', $lead->notes ?? '') . '"',
            ]) . "\n";
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'leads-' . now()->format('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function getFilteredQuery()
    {
        return Lead::query()
            ->with(['property', 'assignedAgent'])
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterSource, fn ($q) => $q->where('source', $this->filterSource))
            ->when($this->search, fn ($q) => $q->where(function ($sub) {
                $sub->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%");
            }))
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        return view('livewire.lead-manager', [
            'leads' => $this->getFilteredQuery()->paginate(20),
            'agents' => User::where('role', 'agent')->orderBy('name')->get(),
            'stats' => [
                'total' => Lead::count(),
                'new' => Lead::new()->count(),
                'unassigned' => Lead::unassigned()->count(),
                'assigned' => Lead::byStatus('assigned')->count(),
            ],
        ]);
    }
}
