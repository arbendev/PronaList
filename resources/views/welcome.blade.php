@extends('layouts.app')

@section('title', __('general.nav_home'))

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section text-center" style="background-image: url('{{ asset('img/bg-kosova.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container hero-content">
            <h1 class="hero-title">{{ __('general.hero_title') }}</h1>
            <p class="hero-subtitle">{{ __('general.hero_subtitle') }}</p>

            <livewire:hero-search />
        </div>
    </section>

    {{-- Featured Properties --}}
    @if($featured->count())
    <section class="section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">{{ __('general.featured_title') }}</h2>
                <p class="section-subtitle">{{ __('general.featured_subtitle') }}</p>
            </div>

            <div class="row g-4">
                @foreach($featured as $property)
                    <div class="col-md-4 col-lg-3">
                        <x-property-card :property="$property" />
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('properties.search') }}" class="btn btn-outline-custom">{{ __('general.view_all') }}</a>
            </div>
        </div>
    </section>
    @endif

    {{-- Browse by Type --}}
    @if($types->count())
    <section class="section-padding" style="background:#fff">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">{{ __('general.types_title') }}</h2>
                <p class="section-subtitle">{{ __('general.types_subtitle') }}</p>
            </div>

            <div class="row g-4">
                @foreach($types as $type)
                    <div class="col-6 col-md-4 col-lg">
                        <a href="{{ route('properties.search', ['type' => $type->id]) }}" style="text-decoration:none">
                            <div class="type-card">
                                <div class="type-icon">{!! $type->icon !!}</div>
                                <div class="type-name">{{ $type->translated_name }}</div>
                                <div class="type-count">{{ $type->properties_count }} {{ __('general.stats_properties') }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Stats --}}
    {{-- 
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['properties'] }}+</div>
                        <div class="stat-label">{{ __('general.stats_properties') }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['agents'] }}+</div>
                        <div class="stat-label">{{ __('general.stats_agents') }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">{{ $stats['cities'] }}+</div>
                        <div class="stat-label">{{ __('general.stats_cities') }}</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">{{ __('general.stats_happy') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    --}}

    {{-- Recently Added --}}
    @if($recent->count())
    <section class="section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">{{ __('general.recent_title') }}</h2>
                <p class="section-subtitle">{{ __('general.recent_subtitle') }}</p>
            </div>

            <div class="row g-4">
                @foreach($recent as $property)
                    <div class="col-md-6 col-lg-3">
                        <x-property-card :property="$property" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">{{ __('general.cta_title') }}</h2>
            <p class="cta-subtitle">{{ __('general.cta_subtitle') }}</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('properties.search') }}" class="btn btn-primary-custom btn-lg">{{ __('general.cta_search') }}</a>
                <a href="{{ route('list-property') }}" class="btn btn-outline-custom btn-lg" style="border-color:#fff;color:#fff">{{ __('general.cta_list') }}</a>
            </div>
        </div>
    </section>
@endsection
