{{-- Guest layout wrapper for unauthenticated pages --}}
<x-guest-layout>
    {{-- Email verification instructions message --}}
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    {{-- Success message shown when verification link is resent --}}
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    {{-- Action buttons container --}}
    <div class="mt-4 flex items-center justify-between">
        {{-- Resend verification email form --}}
        <form method="POST" action="{{ route('verification.send') }}">
            {{-- CSRF token for security --}}
            @csrf

            <div>
                {{-- Resend button component --}}
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        {{-- Logout form --}}
        <form method="POST" action="{{ route('logout') }}">
            {{-- CSRF token for security --}}
            @csrf

            {{-- Logout button --}}
            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>