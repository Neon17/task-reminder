<x-form-section submit="sendVerificationEmail">
    <x-slot name="title">
        {{ __('Email Verification') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Verify your email address to secure your account.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            @if (auth()->user()->hasVerifiedEmail())
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-600 font-medium">{{ __('Email Verified') }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Your email address was verified on') }} {{ auth()->user()->email_verified_at->format('M d, Y') }}.
                </p>
            @else
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-yellow-600 font-medium">{{ __('Email Not Verified') }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Your email address is not verified. Please check your inbox for a verification email.') }}
                </p>
            @endif

            @if (session()->has('message'))
                <div class="mt-4 text-sm font-medium text-green-600">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </x-slot>

    @if (!auth()->user()->hasVerifiedEmail())
        <x-slot name="actions">
            <x-button wire:loading.attr="disabled">
                {{ __('Resend Verification Email') }}
            </x-button>
        </x-slot>
    @endif
</x-form-section>