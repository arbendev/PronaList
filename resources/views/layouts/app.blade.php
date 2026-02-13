<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', __('general.footer_about_text'))">

    <title>@yield('title', 'ProKos') – {{ config('app.name', 'ProKos') }}</title>

    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body>
    <div id="app">
        {{-- ── Navbar ────────────────────────────────── --}}
        <nav class="navbar navbar-expand-lg navbar-prokos sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Pro<span>Kos</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#mainNav" aria-controls="mainNav"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    {{-- Left Nav --}}
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                               href="{{ url('/') }}">{{ __('general.nav_home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('properties*') ? 'active' : '' }}"
                               href="{{ route('properties.search', ['listing_type' => 'sale']) }}">{{ __('general.nav_buy') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('properties.search', ['listing_type' => 'rent']) }}">{{ __('general.nav_rent') }}</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->is('mortgage*') ? 'active' : '' }}"
                               href="{{ route('mortgage') }}">{{ __('general.nav_mortgage') }}</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                               href="{{ route('about') }}">{{ __('general.nav_about') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                               href="{{ route('contact') }}">{{ __('general.nav_contact') }}</a>
                        </li>
                    </ul>

                    {{-- Right Nav --}}
                    <ul class="navbar-nav ms-auto align-items-center gap-2">
                        {{-- Language Switcher --}}
                        <li class="nav-item">
                            <livewire:language-switcher />
                        </li>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('general.nav_login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('general.nav_register') }}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-list-property" href="{{ route('list-property') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                    {{ __('general.nav_list_property') }}
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                                   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ Auth::user()->avatar_url }}" alt="" width="32" height="32"
                                         class="rounded-circle" style="object-fit:cover">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                                            {{ __('general.nav_dashboard') }}
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('general.nav_logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- ── Main Content ──────────────────────────── --}}
        <main>
            @yield('content')
        </main>

        {{-- ── Footer ────────────────────────────────── --}}
        @include('components.footer')
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
