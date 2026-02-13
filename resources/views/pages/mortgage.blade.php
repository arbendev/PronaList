@extends('layouts.app')
@section('title', __('general.mortgage_title'))
@section('content')
    <div class="section-padding">
        <div class="container" style="max-width:800px">
            <div class="text-center mb-4">
                <h1 style="font-weight:800;color:#1a1a2e">{{ __('general.mortgage_title') }}</h1>
                <p class="text-muted">{{ __('general.mortgage_subtitle') }}</p>
            </div>
            <livewire:mortgage-calculator />
        </div>
    </div>
@endsection
