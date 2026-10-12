<x-guest-layout>
    <h2>{{ __('Willkommen zurück') }}</h2>
    <p class="sub">{{ __('Melden Sie sich bei Ihrem Konto an.') }}</p>
    <x-auth-session-status :status="session('status')" />
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <label for="email">{{ __('E-Mail-Adresse') }}</label>
            <input class="field-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@firma.de" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <div class="field">
            <label for="password">{{ __('Passwort') }}</label>
            <input class="field-input" id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" />
        </div>
        <div class="login-row">
            <label class="check"><input id="remember_me" type="checkbox" name="remember">{{ __('Angemeldet bleiben') }}</label>
            @if (Route::has('password.request'))
                <a class="flink" href="{{ route('password.request') }}">{{ __('Passwort vergessen?') }}</a>
            @endif
        </div>
        <button type="submit" class="btn btn-brand btn-block">{{ __('Anmelden') }}</button>
    </form>
    <div class="divider">{{ __('oder') }}</div>
    <p class="reg">{{ __('Noch kein Konto?') }} <a class="flink" href="{{ route('register') }}">{{ __('Jetzt registrieren') }}</a></p>
</x-guest-layout>
