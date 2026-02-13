@extends('layouts.app')
@section('title', $agent->name)
@section('content')
    <div class="section-padding">
        <div class="container" style="max-width:900px">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="agent-card">
                        <img src="{{ $agent->avatar_url }}" alt="{{ $agent->name }}" class="agent-avatar">
                        <h4 class="agent-name">{{ $agent->name }}</h4>
                        @if($agent->agency_name)
                            <div class="agent-agency">{{ $agent->agency_name }}</div>
                        @endif
                        @if($agent->is_verified)
                            <div class="agent-verified-badge mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                                </svg>
                                {{ __('general.agent_verified') }}
                            </div>
                        @endif
                        <div class="text-start mt-3">
                            @if($agent->phone)
                                <p class="mb-2" style="font-size:0.9rem"><strong>{{ __('general.agent_phone') }}:</strong> {{ $agent->phone }}</p>
                            @endif
                            <p class="mb-2" style="font-size:0.9rem"><strong>{{ __('general.agent_email') }}:</strong> {{ $agent->email }}</p>
                            @if($agent->license_number)
                                <p class="mb-0" style="font-size:0.9rem"><strong>{{ __('general.agent_license') }}:</strong> {{ $agent->license_number }}</p>
                            @endif
                        </div>
                        @if($agent->bio)
                            <p class="mt-3 text-muted" style="font-size:0.9rem;line-height:1.7">{{ $agent->bio }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <h4 class="fw-bold mb-3">{{ __('general.agent_listings') }} ({{ $properties->count() }})</h4>
                    @if($properties->count())
                        <div class="row g-3">
                            @foreach($properties as $property)
                                <div class="col-md-6">
                                    <x-property-card :property="$property" />
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No active listings.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
