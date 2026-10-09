<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <title>COMPLYN — {{ __('Compliance-Plattform für den Mittelstand') }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
               background: #f8fafc; color: #0f172a; }
        .nav { display: flex; align-items: center; justify-content: space-between; padding: 1rem 2rem;
               background: #0f172a; }
        .brand { display: flex; align-items: center; gap: .65rem; color: #fff; font-weight: 700;
                 letter-spacing: .18em; font-size: .95rem; }
        .brand .mark { width: 2rem; height: 2rem; border-radius: .5rem; background: #f59e0b; color: #0f172a;
                       display: flex; align-items: center; justify-content: center; font-weight: 800; }
        .nav a { color: #cbd5e1; text-decoration: none; font-size: .875rem; margin-left: 1.25rem; }
        .nav a.cta { background: #f59e0b; color: #0f172a; padding: .5rem 1rem; border-radius: .65rem;
                     font-weight: 600; }
        .hero { max-width: 72rem; margin: 0 auto; padding: 5rem 2rem 3rem; display: grid;
                grid-template-columns: 1.1fr .9fr; gap: 3rem; align-items: center; }
        .eyebrow { display: inline-block; font-size: .75rem; font-weight: 700; letter-spacing: .12em;
                   text-transform: uppercase; color: #b45309; background: #fef3c7;
                   padding: .35rem .8rem; border-radius: 999px; margin-bottom: 1.25rem; }
        h1 { font-size: 3rem; line-height: 1.08; margin: 0 0 1.1rem; font-weight: 800; letter-spacing: -.02em; }
        h1 span { color: #f59e0b; }
        .lead { color: #475569; font-size: 1.125rem; line-height: 1.65; margin: 0 0 2rem; max-width: 34rem; }
        .actions { display: flex; gap: .75rem; flex-wrap: wrap; }
        .btn { display: inline-block; padding: .85rem 1.6rem; border-radius: .75rem; font-weight: 700;
               font-size: .95rem; text-decoration: none; }
        .btn-primary { background: #0f172a; color: #fff; }
        .btn-ghost { background: #fff; color: #0f172a; border: 1px solid #cbd5e1; }
        .panel { background: #0f172a; border-radius: 1.5rem; padding: 2rem; color: #e2e8f0; }
        .panel h2 { font-size: .8rem; letter-spacing: .15em; text-transform: uppercase; color: #f59e0b;
                    margin: 0 0 1.25rem; }
        .pillars { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .pillar { background: #1e293b; border-radius: 1rem; padding: 1.1rem 1.2rem; }
        .pillar b { display: block; font-size: .95rem; margin-bottom: .3rem; }
        .pillar span { font-size: .8rem; color: #94a3b8; line-height: 1.5; }
        .strip { max-width: 72rem; margin: 0 auto; padding: 0 2rem 4rem; display: grid;
                 grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem;
                box-shadow: 0 1px 2px rgb(0 0 0 / .05); }
        .card b { display: block; font-size: .95rem; margin-bottom: .4rem; }
        .card p { margin: 0; color: #64748b; font-size: .875rem; line-height: 1.6; }
        .foot { padding: 1.5rem 2rem; text-align: center; color: #94a3b8; font-size: .8rem;
                border-top: 1px solid #e2e8f0; }
        @media (max-width: 900px) {
            .hero { grid-template-columns: 1fr; padding-top: 3rem; }
            h1 { font-size: 2.25rem; }
            .strip { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="brand"><span class="mark">C</span> COMPLYN</div>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="cta">{{ __('Dashboard') }}</a>
            @else
                <a href="{{ route('login') }}">{{ __('Anmelden') }}</a>
                <a href="{{ route('register') }}" class="cta">{{ __('Kostenlos starten') }}</a>
            @endauth
        </div>
    </nav>

    <section class="hero">
        <div>
            <span class="eyebrow">{{ __('Compliance, vereinfacht') }}</span>
            <h1>{{ __('Compliance für den') }} <span>{{ __('Mittelstand') }}</span></h1>
            <p class="lead">{{ __('COMPLYN bündelt Dokumente, Coaching, Expertennetzwerk und Lernmodule in einer modularen Plattform — DSGVO-konform und bereit für Ihr Unternehmen.') }}</p>
            <div class="actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">{{ __('Zum Dashboard') }}</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Jetzt registrieren') }}</a>
                    <a href="{{ route('login') }}" class="btn btn-ghost">{{ __('Anmelden') }}</a>
                @endauth
            </div>
        </div>
        <div class="panel">
            <h2>{{ __('Die vier Säulen') }}</h2>
            <div class="pillars">
                <div class="pillar"><b>{{ __('Verwalten') }}</b><span>{{ __('Dokumente, Dateien und Benachrichtigungen zentral organisieren.') }}</span></div>
                <div class="pillar"><b>{{ __('Verstehen') }}</b><span>{{ __('KI-Coach und Community beantworten Ihre Compliance-Fragen.') }}</span></div>
                <div class="pillar"><b>{{ __('Lösen') }}</b><span>{{ __('Experten, Vorlagen und Bibliothek für konkrete Fälle.') }}</span></div>
                <div class="pillar"><b>{{ __('Verbessern') }}</b><span>{{ __('Kurse, Score und Benchmarking für kontinuierliche Fortschritte.') }}</span></div>
            </div>
        </div>
    </section>

    <section class="strip">
        <div class="card"><b>{{ __('Modular & planbasiert') }}</b><p>{{ __('Jeder Block lässt sich pro Tarif zuschalten — Sie zahlen nur, was Sie nutzen.') }}</p></div>
        <div class="card"><b>{{ __('KI-gestützt') }}</b><p>{{ __('Coach und Creator nutzen KI für Antworten, Checklisten und Dokumente.') }}</p></div>
        <div class="card"><b>{{ __('DSGVO-konform') }}</b><p>{{ __('Audit-Logs, Rollen und Datenverwaltung nach deutschen Standards.') }}</p></div>
    </section>

    <footer class="foot">COMPLYN — {{ __('Compliance-Plattform für den Mittelstand') }}</footer>
</body>
</html>
