@extends('layouts.app')
@section('title', __('general.about_title'))
@section('content')
    <div class="about-page">
        <div class="about-hero">
            <div class="container">
                <h1>{{ __('general.about_title') }}</h1>
                <p class="mt-2 mb-0" style="font-size:1.15rem;opacity:0.85">{{ __('general.about_subtitle') }}</p>
            </div>
        </div>

        <div class="about-content">
            <div class="container" style="max-width:900px">
                <div class="about-card">
                    <h3>{{ __('general.about_mission') }}</h3>
                    <p>{{ __('general.about_mission_text') }}</p>
                </div>

                <div class="about-card">
                    <h3>{{ __('general.about_story') }}</h3>
                    <p>{{ __('general.about_story_text') }}</p>
                </div>

                <div class="about-card">
                    <div class="row g-4 text-center">
                        <div class="col-md-3 col-6">
                            <div style="font-size:2rem;font-weight:800;color:#006AFF">{{ $stats['properties'] }}+</div>
                            <div class="text-muted" style="font-size:0.9rem">{{ __('general.stats_properties') }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="font-size:2rem;font-weight:800;color:#006AFF">{{ $stats['agents'] }}+</div>
                            <div class="text-muted" style="font-size:0.9rem">{{ __('general.stats_agents') }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="font-size:2rem;font-weight:800;color:#006AFF">{{ $stats['cities'] }}+</div>
                            <div class="text-muted" style="font-size:0.9rem">{{ __('general.stats_cities') }}</div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div style="font-size:2rem;font-weight:800;color:#006AFF">500+</div>
                            <div class="text-muted" style="font-size:0.9rem">{{ __('general.stats_happy') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
