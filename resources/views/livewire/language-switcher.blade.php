<div class="lang-switcher d-flex gap-1">
    <button wire:click="switchLocale('en')"
            class="btn-lang {{ $currentLocale === 'en' ? 'active' : '' }}">
        EN
    </button>
    <button wire:click="switchLocale('sq')"
            class="btn-lang {{ $currentLocale === 'sq' ? 'active' : '' }}">
        SQ
    </button>
</div>
