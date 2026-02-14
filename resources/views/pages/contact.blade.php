@extends('layouts.app')
@section('title', __('general.contact_page_title'))
@section('content')
    <div class="contact-page">
        <div class="container">
            <div class="text-center mb-5">
                <h1 style="font-weight:800;color:#1a1a2e">{{ __('general.contact_page_title') }}</h1>
                <p class="text-muted" style="max-width:600px;margin:0 auto">{{ __('general.contact_page_subtitle') }}</p>
            </div>

            <div class="row g-4" style="max-width:1000px;margin:0 auto">
                <div class="col-md-8">
                    <livewire:contact-page />
                </div>
            </div>
        </div>
    </div>
@endsection
