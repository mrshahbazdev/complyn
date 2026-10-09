<x-guest-layout>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <h2 class="text-2xl font-bold text-slate-900">{{ __('Willkommen zurück') }}</h2>
    <p class="mt-1 text-sm text-slate-500 mb-6">{{ __('Melden Sie sich bei Ihrem COMPLYN-Konto an.') }}</p>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-amber-500 shadow-sm focus:ring-amber-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 flex items-center justify-between text-sm">
        <a class="text-slate-500 hover:text-slate-900" href="{{ route('register') }}">
            {{ __('Noch kein Konto? Registrieren') }}
        </a>
        @if (Route::has('password.request'))
            <a class="text-amber-600 hover:text-amber-700 font-medium" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
    </div>
    </div>
</x-guest-layout>
