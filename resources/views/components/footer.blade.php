{{-- Footer Component --}}
<footer class="footer">
    <div class="container">
        <div class="row g-4">
            {{-- About --}}
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand">Prona<span>List</span></div>
                <p class="footer-text">{{ __('general.footer_about_text') }}</p>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title">{{ __('general.footer_links') }}</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('properties.search', ['listing_type' => 'sale']) }}">{{ __('general.nav_buy') }}</a></li>
                    <li><a href="{{ route('properties.search', ['listing_type' => 'rent']) }}">{{ __('general.nav_rent') }}</a></li>
                    {{-- <li><a href="{{ route('mortgage') }}">{{ __('general.nav_mortgage') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('general.nav_about') }}</a></li>  --}}
                    <li><a href="{{ route('contact') }}">{{ __('general.nav_contact') }}</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title">{{ __('general.footer_support') }}</h6>
                <ul class="footer-links">
                    <li><a href="#">{{ __('general.footer_faq') }}</a></li>
                    <li><a href="#">{{ __('general.footer_help') }}</a></li>
                    <li><a href="#">{{ __('general.footer_privacy') }}</a></li>
                    <li><a href="#">{{ __('general.footer_terms') }}</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-title">{{ __('general.footer_newsletter') }}</h6>
                <p class="footer-text mb-3">{{ __('general.footer_newsletter_text') }}</p>
                <div class="footer-newsletter">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="{{ __('general.footer_email_placeholder') }}">
                        <button class="btn" type="button">{{ __('general.footer_subscribe') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom text-center">
            &copy; {{ date('Y') }} PronaList. {{ __('general.footer_rights') }}
        </div>
    </div>
</footer>
