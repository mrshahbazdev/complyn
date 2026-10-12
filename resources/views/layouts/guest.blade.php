<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'COMPLYN') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/uikit.css') }}">
    </head>
    <body>
        <div class="login-wrap">
            <div class="login-left">
                <a href="/" class="brand"><span class="logo-mark">C</span><span class="logo-name">COMPLYN</span></a>
                <div>
                    <h1>{{ __('Compliance, die') }} <span>{{ __('mitdenkt.') }}</span></h1>
                    <p class="lead">{{ __('Dokumente, KI-Coach, Expertennetzwerk und Academy — alles in einer modularen Plattform für den deutschen Mittelstand.') }}</p>
                    <ul class="lbul">
                        <li><span class="ck"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span><div><b>{{ __('Modulare Plattform') }}</b><p>{{ __('Blöcke und Module lassen sich einzeln aktivieren — Sie zahlen nur, was Sie nutzen.') }}</p></div></li>
                        <li><span class="ck"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span><div><b>{{ __('KI-Coach inklusive') }}</b><p>{{ __('Analysen, Handlungsempfehlungen und Checklisten auf Knopfdruck.') }}</p></div></li>
                        <li><span class="ck"><svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></span><div><b>{{ __('DSGVO-konform') }}</b><p>{{ __('Audit-Logs, Rollen und Nachweise nach deutschen Standards.') }}</p></div></li>
                    </ul>
                </div>
                <div class="fine"><span>© {{ date('Y') }} COMPLYN — DISAVO</span></div>
            </div>
            <div class="login-right">
                <div style="width:100%;max-width:420px">
                    <a href="/"><span class="logo-mark">C</span>COMPLYN</a>
                    <div class="login-card fade-up">
                        <div></div>
                        {{ $slot }}
                        <div style="margin-top:20px;text-align:center">
                            <span class="check" style="justify-content:center">
                                <a href="{{ route('lang.switch', 'de') }}" class="flink" style="{{ app()->getLocale() === 'de' ? '' : 'color:var(--slate-400);font-weight:600' }}">DE</a>
                                <span style="color:var(--slate-300)">·</span>
                                <a href="{{ route('lang.switch', 'en') }}" class="flink" style="{{ app()->getLocale() === 'en' ? '' : 'color:var(--slate-400);font-weight:600' }}">EN</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
