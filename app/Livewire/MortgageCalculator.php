<?php

namespace App\Livewire;

use Livewire\Component;

class MortgageCalculator extends Component
{
    public float $price = 150000;
    public float $downPaymentPercent = 20;
    public float $interestRate = 4.5;
    public int $loanTerm = 25;

    public float $monthlyPayment = 0;
    public float $totalInterest = 0;
    public float $totalCost = 0;
    public float $loanAmount = 0;

    public function mount(float $price = 150000): void
    {
        $this->price = $price;
        $this->calculate();
    }

    public function updated(): void
    {
        $this->calculate();
    }

    public function calculate(): void
    {
        $this->loanAmount = $this->price * (1 - $this->downPaymentPercent / 100);
        $monthlyRate = ($this->interestRate / 100) / 12;
        $numPayments = $this->loanTerm * 12;

        if ($monthlyRate > 0 && $numPayments > 0 && $this->loanAmount > 0) {
            $this->monthlyPayment = $this->loanAmount *
                ($monthlyRate * pow(1 + $monthlyRate, $numPayments)) /
                (pow(1 + $monthlyRate, $numPayments) - 1);

            $this->totalCost = $this->monthlyPayment * $numPayments;
            $this->totalInterest = $this->totalCost - $this->loanAmount;
        } else {
            $this->monthlyPayment = 0;
            $this->totalInterest = 0;
            $this->totalCost = 0;
        }
    }

    public function render()
    {
        return view('livewire.mortgage-calculator');
    }
}
