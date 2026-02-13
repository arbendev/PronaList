<div class="contact-form-card">
    @if($sent)
        <div class="alert-success-custom">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            {{ __('general.contact_sent') }}
        </div>
    @else
        <form wire:submit="send">
            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('general.contact_name') }}</label>
                <input type="text" wire:model="name" class="form-control">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('general.contact_email') }}</label>
                <input type="email" wire:model="email" class="form-control">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('general.contact_phone') }}</label>
                <input type="tel" wire:model="phone" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">{{ __('general.contact_message') }}</label>
                <textarea wire:model="message" class="form-control" rows="5"></textarea>
                @error('message') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <button type="submit" class="btn btn-primary-custom w-100">
                <span wire:loading.remove wire:target="send">{{ __('general.contact_send') }}</span>
                <span wire:loading wire:target="send">Sending...</span>
            </button>
        </form>
    @endif
</div>
