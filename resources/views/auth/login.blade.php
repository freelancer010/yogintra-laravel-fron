@section('title', 'Login - Yogintra')

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" class="font-semibold text-slate-700" />
            <x-text-input id="email" class="block mt-2 w-full rounded-lg border-slate-200 px-4 py-3 shadow-sm focus:border-[#16717a] focus:ring-[#16717a]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="font-semibold text-slate-700" />

            <x-text-input id="password" class="block mt-2 w-full rounded-lg border-slate-200 px-4 py-3 shadow-sm focus:border-[#16717a] focus:ring-[#16717a]"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between gap-4 pt-1">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#16717a] shadow-sm focus:ring-[#16717a]" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#16717a] hover:text-[#0f5962] focus:outline-none focus:ring-2 focus:ring-[#16717a] focus:ring-offset-2 rounded" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="pt-1">
            <x-primary-button class="w-full justify-center rounded-lg bg-[#16717a] px-4 py-3 text-sm tracking-wide shadow-lg shadow-[#16717a]/20 hover:bg-[#0f5962] focus:bg-[#0f5962] focus:ring-[#16717a]">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
