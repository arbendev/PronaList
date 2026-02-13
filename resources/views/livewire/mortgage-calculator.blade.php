<div class="mortgage-calculator">
    <h4 class="mb-1" style="font-weight:700">{{ __('general.mortgage_title') }}</h4>
    <p class="text-muted mb-4" style="font-size:0.9rem">{{ __('general.mortgage_subtitle') }}</p>

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label fw-semibold" style="font-size:0.875rem">{{ __('general.mortgage_price') }}</label>
            <div class="input-group">
                <span class="input-group-text">€</span>
                <input type="number" wire:model.live.debounce.300ms="price" class="form-control" min="0" step="1000">
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold" style="font-size:0.875rem">{{ __('general.mortgage_down_pct') }}</label>
            <div class="input-group">
                <input type="number" wire:model.live.debounce.300ms="downPaymentPercent" class="form-control" min="0" max="100" step="1">
                <span class="input-group-text">%</span>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold" style="font-size:0.875rem">{{ __('general.mortgage_rate') }}</label>
            <div class="input-group">
                <input type="number" wire:model.live.debounce.300ms="interestRate" class="form-control" min="0" max="30" step="0.1">
                <span class="input-group-text">%</span>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold" style="font-size:0.875rem">{{ __('general.mortgage_term') }}</label>
            <div class="input-group">
                <input type="number" wire:model.live.debounce.300ms="loanTerm" class="form-control" min="1" max="40" step="1">
                <span class="input-group-text">{{ __('general.mortgage_term') }}</span>
            </div>
        </div>
    </div>

    {{-- Result --}}
    <div class="calc-result">
        <div class="monthly-payment">€{{ number_format($monthlyPayment, 0, ',', '.') }}</div>
        <div class="payment-label">{{ __('general.mortgage_monthly') }}</div>
    </div>

    {{-- Breakdown --}}
    <div class="calc-breakdown">
        <div class="breakdown-item">
            <div class="breakdown-value">€{{ number_format($loanAmount, 0, ',', '.') }}</div>
            <div class="breakdown-label">{{ __('general.mortgage_loan_amount') }}</div>
        </div>
        <div class="breakdown-item">
            <div class="breakdown-value">€{{ number_format($totalInterest, 0, ',', '.') }}</div>
            <div class="breakdown-label">{{ __('general.mortgage_total_interest') }}</div>
        </div>
        <div class="breakdown-item">
            <div class="breakdown-value">€{{ number_format($totalCost, 0, ',', '.') }}</div>
            <div class="breakdown-label">{{ __('general.mortgage_total_cost') }}</div>
        </div>
    </div>
</div>
