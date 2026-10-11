<x-guest-layout>
    <h2>{{ __('E-Mail bestätigen') }}</h2>
    <p class="sub">{{ __('Bitte bestätigen Sie Ihre E-Mail-Adresse über den Link, den wir Ihnen gesendet haben. Kein Link erhalten? Wir senden ihn gerne erneut.') }}</p>
    @if (session('status') == 'verification-link-sent')
        <p class="sub" style="color:var(--brand-700);font-weight:700">{{ __('Ein neuer Bestätigungslink wurde an Ihre E-Mail-Adresse gesendet.') }}</p>
    @endif
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-brand btn-block">{{ __('Link erneut senden') }}</button>
    </form>
    <div class="divider">{{ __('oder') }}</div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <p class="reg"><button type="submit" class="flink" style="background:none;border:0">{{ __('Abmelden') }}</button></p>
    </form>
</x-guest-layout>
