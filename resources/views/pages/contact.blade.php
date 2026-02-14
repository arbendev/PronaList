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
                <div class="col-md-5">
                    <div class="contact-info-card">
                        <div class="info-item">
                            <div class="info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                </svg>
                            </div>
                            <div>
                                <h5>{{ __('general.contact_address') }}</h5>
                                <p>{{ __('general.contact_address_value') }}</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                                </svg>
                            </div>
                            <div>
                                <h5>{{ __('general.contact_email') }}</h5>
                                <p>info@pronalist.com</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58z"/>
                                </svg>
                            </div>
                            <div>
                                <h5>{{ __('general.contact_phone') }}</h5>
                                <p>+355 69 xxx xxxx</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <livewire:contact-page />
                </div>
            </div>
        </div>
    </div>
@endsection
