<x-guest-layout>
    <h2>{{ __('Passwort vergessen?') }}</h2>
    <p class="sub">{{ __('Geben Sie Ihre E-Mail-Adresse ein — wir senden Ihnen einen Link zum Zurücksetzen.') }}</p>
    <x-auth-session-status :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="field">
            <label for="email">{{ __('E-Mail-Adresse') }}</label>
            <input class="field-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@firma.de" required autofocus>
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <button type="submit" class="btn btn-brand btn-block">{{ __('Link senden') }}</button>
    </form>
    <div class="divider">{{ __('oder') }}</div>
    <p class="reg"><a class="flink" href="{{ route('login') }}">{{ __('Zurück zur Anmeldung') }}</a></p>
</x-guest-layout>
