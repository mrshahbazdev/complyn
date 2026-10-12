<x-guest-layout>
    <h2>{{ __('Konto erstellen') }}</h2>
    <p class="sub">{{ __('Starten Sie mit dem Basis-Plan — kostenlos.') }}</p>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label for="name">{{ __('Name') }}</label>
            <input class="field-input" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Max Mustermann" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" />
        </div>
        <div class="field">
            <label for="company_name">{{ __('Unternehmen') }}</label>
            <input class="field-input" id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Musterfirma GmbH" required autocomplete="organization">
            <x-input-error :messages="$errors->get('company_name')" />
        </div>
        <div class="field">
            <label for="email">{{ __('E-Mail-Adresse') }}</label>
            <input class="field-input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@firma.de" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" />
        </div>
        <div class="field">
            <label for="password">{{ __('Passwort') }}</label>
            <input class="field-input" id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" />
        </div>
        <div class="field">
            <label for="password_confirmation">{{ __('Passwort bestätigen') }}</label>
            <input class="field-input" id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>
        <button type="submit" class="btn btn-brand btn-block">{{ __('Registrieren') }}</button>
    </form>
    <div class="divider">{{ __('oder') }}</div>
    <p class="reg">{{ __('Bereits ein Konto?') }} <a class="flink" href="{{ route('login') }}">{{ __('Jetzt anmelden') }}</a></p>
</x-guest-layout>
