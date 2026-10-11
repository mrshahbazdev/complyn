<x-guest-layout>
    <h2>{{ __('Neues Passwort') }}</h2>
    <p class="sub">{{ __('Wählen Sie ein neues Passwort für Ihr Konto.') }}</p>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="field">
            <label for="email">{{ __('E-Mail-Adresse') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>
        <div class="field">
            <label for="password">{{ __('Passwort') }}</label>
            <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>
        <div class="field">
            <label for="password_confirmation">{{ __('Passwort bestätigen') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>
        <button type="submit" class="btn btn-brand btn-block">{{ __('Passwort zurücksetzen') }}</button>
    </form>
</x-guest-layout>
