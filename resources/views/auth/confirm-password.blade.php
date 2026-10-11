<x-guest-layout>
    <h2>{{ __('Passwort bestätigen') }}</h2>
    <p class="sub">{{ __('Dies ist ein geschützter Bereich — bitte bestätigen Sie Ihr Passwort.') }}</p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="field">
            <label for="password">{{ __('Passwort') }}</label>
            <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>
        <button type="submit" class="btn btn-brand btn-block">{{ __('Bestätigen') }}</button>
    </form>
</x-guest-layout>
