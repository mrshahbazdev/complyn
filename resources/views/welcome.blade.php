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

        .nav { position: sticky; top: 0; z-index: 20; display: flex; align-items: center;
               justify-content: space-between; padding: 1rem 2.5rem; background: rgba(15,23,42,.97); }
        .brand { display: flex; align-items: center; gap: .65rem; color: #fff; font-weight: 800;
                 letter-spacing: .2em; }
        .brand .mark { width: 2.1rem; height: 2.1rem; border-radius: .55rem; background: #f59e0b;
                       color: #0f172a; display: flex; align-items: center; justify-content: center; }
        .nav-links { display: flex; align-items: center; gap: 1.5rem; }
        .nav-links a { color: #cbd5e1; text-decoration: none; font-size: .875rem; }
        .nav-links a:hover { color: #fff; }
        .nav-links a.cta { background: #f59e0b; color: #0f172a; padding: .55rem 1.15rem;
                           border-radius: .7rem; font-weight: 700; }
        .lang-sw { display: inline-flex; border: 1px solid #334155; border-radius: 999px; overflow: hidden; }
        .lang-sw a { padding: .3rem .75rem; font-size: .75rem; font-weight: 700; color: #94a3b8;
                     letter-spacing: .05em; }
        .lang-sw a.on { background: #f59e0b; color: #0f172a; }

        .hero { background: #0f172a; color: #e2e8f0; padding: 5.5rem 2.5rem 5rem; }
        .hero-inner { max-width: 72rem; margin: 0 auto; display: grid;
                      grid-template-columns: 1.05fr .95fr; gap: 4rem; align-items: center; }
        .eyebrow { display: inline-flex; align-items: center; gap: .5rem; font-size: .72rem;
                   font-weight: 700; letter-spacing: .14em; text-transform: uppercase;
                   color: #fbbf24; background: rgba(245,158,11,.12); border: 1px solid rgba(245,158,11,.35);
                   padding: .4rem .9rem; border-radius: 999px; margin-bottom: 1.4rem; }
        .eyebrow .dot { width: .45rem; height: .45rem; border-radius: 999px; background: #f59e0b; }
        h1 { font-size: 3.4rem; line-height: 1.05; margin: 0 0 1.25rem; font-weight: 800;
             letter-spacing: -.025em; color: #fff; }
        h1 span { color: #f59e0b; }
        .lead { color: #94a3b8; font-size: 1.15rem; line-height: 1.7; margin: 0 0 2.2rem; max-width: 33rem; }
        .actions { display: flex; gap: .8rem; flex-wrap: wrap; margin-bottom: 2.6rem; }
        .btn { display: inline-block; padding: .9rem 1.7rem; border-radius: .8rem; font-weight: 700;
               font-size: .95rem; text-decoration: none; }
        .btn-primary { background: #f59e0b; color: #0f172a; }
        .btn-ghost { background: transparent; color: #e2e8f0; border: 1px solid #334155; }
        .hero-stats { display: flex; gap: 2.5rem; }
        .stat b { display: block; font-size: 1.6rem; color: #fff; }
        .stat span { font-size: .78rem; color: #64748b; text-transform: uppercase; letter-spacing: .08em; }

        .pillar-panel { background: #1e293b; border: 1px solid #334155; border-radius: 1.5rem;
                        padding: 2.2rem; }
        .pillar-panel h2 { font-size: .78rem; letter-spacing: .16em; text-transform: uppercase;
                           color: #f59e0b; margin: 0 0 1.5rem; }
        .pillars { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .pillar { background: #0f172a; border: 1px solid #243247; border-radius: 1rem;
                  padding: 1.2rem 1.3rem; }
        .pillar .ico { width: 2.2rem; height: 2.2rem; border-radius: .6rem; background: rgba(245,158,11,.15);
                       color: #fbbf24; display: flex; align-items: center; justify-content: center;
                       font-weight: 800; font-size: .85rem; margin-bottom: .8rem; }
        .pillar b { display: block; color: #fff; font-size: .95rem; margin-bottom: .35rem; }
        .pillar span { font-size: .82rem; color: #94a3b8; line-height: 1.55; }

        .section { max-width: 72rem; margin: 0 auto; padding: 4.5rem 2.5rem 0; }
        .section-head { text-align: center; margin-bottom: 2.8rem; }
        .section-head .kicker { font-size: .75rem; font-weight: 700; letter-spacing: .14em;
                                text-transform: uppercase; color: #b45309; }
        .section-head h2 { font-size: 2.1rem; font-weight: 800; letter-spacing: -.02em; margin: .5rem 0 .6rem; }
        .section-head p { color: #64748b; max-width: 40rem; margin: 0 auto; line-height: 1.65; }

        .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
        .feature { background: #fff; border: 1px solid #e2e8f0; border-radius: 1.1rem; padding: 1.7rem;
                   box-shadow: 0 1px 2px rgb(0 0 0 / .05); }
        .feature .ico { width: 2.6rem; height: 2.6rem; border-radius: .75rem; background: #fef3c7;
                        color: #b45309; display: flex; align-items: center; justify-content: center;
                        font-weight: 800; margin-bottom: 1rem; }
        .feature b { display: block; font-size: 1rem; margin-bottom: .45rem; }
        .feature p { margin: 0; color: #64748b; font-size: .875rem; line-height: 1.65; }

        .plans { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; align-items: stretch; }
        .plan { background: #fff; border: 1px solid #e2e8f0; border-radius: 1.1rem; padding: 1.9rem;
                display: flex; flex-direction: column; box-shadow: 0 1px 2px rgb(0 0 0 / .05); }
        .plan.hot { background: #0f172a; color: #e2e8f0; border-color: #0f172a; }
        .plan .tag { align-self: flex-start; font-size: .68rem; font-weight: 700; letter-spacing: .1em;
                     text-transform: uppercase; background: #f59e0b; color: #0f172a;
                     border-radius: 999px; padding: .25rem .7rem; margin-bottom: 1rem; }
        .plan h3 { margin: 0 0 .3rem; font-size: 1.15rem; }
        .plan .price { font-size: 2rem; font-weight: 800; margin: .4rem 0 1rem; }
        .plan .price small { font-size: .85rem; font-weight: 500; color: #64748b; }
        .plan.hot .price small { color: #94a3b8; }
        .plan ul { list-style: none; margin: 0 0 1.6rem; padding: 0; flex: 1; }
        .plan li { font-size: .875rem; padding: .4rem 0 .4rem 1.5rem; position: relative; color: #475569; }
        .plan.hot li { color: #cbd5e1; }
        .plan li::before { content: "✓"; position: absolute; left: 0; color: #f59e0b; font-weight: 800; }
        .plan .btn { text-align: center; }
        .plan:not(.hot) .btn { background: #0f172a; color: #fff; }

        .cta-band { margin-top: 4.5rem; background: #0f172a; border-radius: 1.5rem; padding: 3.5rem 3rem;
                    text-align: center; color: #e2e8f0; }
        .cta-band h2 { font-size: 2rem; font-weight: 800; letter-spacing: -.02em; margin: 0 0 .8rem; color: #fff; }
        .cta-band p { color: #94a3b8; max-width: 34rem; margin: 0 auto 2rem; line-height: 1.65; }

        .foot { margin-top: 4.5rem; background: #0f172a; color: #94a3b8; padding: 3.5rem 2.5rem 2rem; }
        .foot-inner { max-width: 72rem; margin: 0 auto; display: grid;
                      grid-template-columns: 1.4fr 1fr 1fr 1fr; gap: 2.5rem; }
        .foot .f-brand { display: flex; align-items: center; gap: .6rem; color: #fff; font-weight: 800;
                         letter-spacing: .2em; margin-bottom: .9rem; }
        .foot .f-brand .mark { width: 1.8rem; height: 1.8rem; border-radius: .45rem; background: #f59e0b;
                               color: #0f172a; display: flex; align-items: center; justify-content: center;
                               font-size: .75rem; }
        .foot .f-about { font-size: .85rem; line-height: 1.65; color: #94a3b8; max-width: 20rem; }
        .foot h4 { color: #fff; font-size: .75rem; letter-spacing: .14em; text-transform: uppercase;
                   margin: 0 0 1rem; }
        .foot ul { list-style: none; margin: 0; padding: 0; }
        .foot li { margin-bottom: .55rem; }
        .foot a { color: #94a3b8; text-decoration: none; font-size: .85rem; }
        .foot a:hover { color: #fbbf24; }
        .foot-bottom { max-width: 72rem; margin: 2.5rem auto 0; padding-top: 1.5rem;
                       border-top: 1px solid #1e293b; display: flex; justify-content: space-between;
                       align-items: center; font-size: .78rem; color: #64748b; }
        .foot-bottom .lang-sw { border-color: #334155; }
        @media (max-width: 960px) {
            .foot-inner { grid-template-columns: 1fr 1fr; }
            .foot-bottom { flex-direction: column; gap: 1rem; }
        }

        @media (max-width: 960px) {
            .hero-inner { grid-template-columns: 1fr; }
            h1 { font-size: 2.4rem; }
            .features, .plans { grid-template-columns: 1fr; }
            .hero-stats { flex-wrap: wrap; gap: 1.5rem; }
            .nav { padding: 1rem 1.25rem; }
            .section { padding: 3rem 1.25rem 0; }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <div class="brand"><span class="mark">C</span> COMPLYN</div>
        <div class="nav-links">
            <span class="lang-sw">
                <a href="{{ route('lang.switch', 'de') }}" class="{{ app()->getLocale() === 'de' ? 'on' : '' }}">DE</a>
                <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'on' : '' }}">EN</a>
            </span>
            @auth
                <a href="{{ route('dashboard') }}" class="cta">{{ __('Dashboard') }}</a>
            @else
                <a href="{{ route('login') }}">{{ __('Anmelden') }}</a>
                <a href="{{ route('register') }}" class="cta">{{ __('Kostenlos starten') }}</a>
            @endauth
        </div>
    </nav>

    <section class="hero">
        <div class="hero-inner">
            <div>
                <span class="eyebrow"><span class="dot"></span>{{ __('Compliance-Plattform für den Mittelstand') }}</span>
                <h1>{{ __('Compliance, die') }} <span>{{ __('mitdenkt') }}</span></h1>
                <p class="lead">{{ __('COMPLYN vereint Dokumentenmanagement, KI-Coaching, Expertennetzwerk und Lernmodule in einer modularen Plattform — damit Mittelständler Vorschriften nicht nur erfüllen, sondern verstehen.') }}</p>
                <div class="actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">{{ __('Zum Dashboard') }}</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Jetzt kostenlos starten') }}</a>
                        <a href="{{ route('login') }}" class="btn btn-ghost">{{ __('Anmelden') }}</a>
                    @endauth
                </div>
                <div class="hero-stats">
                    <div class="stat"><b>10</b><span>{{ __('Module') }}</span></div>
                    <div class="stat"><b>4</b><span>{{ __('Säulen') }}</span></div>
                    <div class="stat"><b>100%</b><span>{{ __('DSGVO-konform') }}</span></div>
                </div>
            </div>
            <div class="pillar-panel">
                <h2>{{ __('Die vier Säulen') }}</h2>
                <div class="pillars">
                    <div class="pillar"><div class="ico">01</div><b>{{ __('Verwalten') }}</b><span>{{ __('Dokumente, Dateien und Benachrichtigungen zentral organisieren.') }}</span></div>
                    <div class="pillar"><div class="ico">02</div><b>{{ __('Verstehen') }}</b><span>{{ __('KI-Coach und Community beantworten Ihre Compliance-Fragen.') }}</span></div>
                    <div class="pillar"><div class="ico">03</div><b>{{ __('Lösen') }}</b><span>{{ __('Experten, Vorlagen und Bibliothek für konkrete Fälle.') }}</span></div>
                    <div class="pillar"><div class="ico">04</div><b>{{ __('Verbessern') }}</b><span>{{ __('Kurse, Score und Benchmarking für kontinuierliche Fortschritte.') }}</span></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-head">
            <div class="kicker">{{ __('Funktionen') }}</div>
            <h2>{{ __('Alles, was Ihr Compliance-Team braucht') }}</h2>
            <p>{{ __('Von der Dokumentenverwaltung bis zum Expertennetzwerk — COMPLYN deckt den gesamten Compliance-Lebenszyklus ab.') }}</p>
        </div>
        <div class="features">
            <div class="feature"><div class="ico">◈</div><b>{{ __('Modular & planbasiert') }}</b><p>{{ __('Jeder Block lässt sich pro Tarif zuschalten — Sie zahlen nur, was Sie nutzen.') }}</p></div>
            <div class="feature"><div class="ico">◆</div><b>{{ __('KI-gestützt') }}</b><p>{{ __('Coach und Creator nutzen KI für Antworten, Checklisten und Dokumente.') }}</p></div>
            <div class="feature"><div class="ico">▣</div><b>{{ __('DSGVO-konform') }}</b><p>{{ __('Audit-Logs, Rollen und Datenverwaltung nach deutschen Standards.') }}</p></div>
            <div class="feature"><div class="ico">◉</div><b>{{ __('Expertennetzwerk') }}</b><p>{{ __('Connect verbindet Sie direkt mit geprüften Compliance-Experten.') }}</p></div>
            <div class="feature"><div class="ico">◧</div><b>{{ __('Wissensbibliothek') }}</b><p>{{ __('Artikel, Vorlagen und Leitfäden — kuratiert für den Mittelstand.') }}</p></div>
            <div class="feature"><div class="ico">▤</div><b>{{ __('Compliance-Score') }}</b><p>{{ __('Messbare Fortschritte: KPIs, Reports und Benchmarking auf einen Blick.') }}</p></div>
        </div>
    </section>

    <section class="section">
        <div class="section-head">
            <div class="kicker">{{ __('Tarife') }}</div>
            <h2>{{ __('Ein Plan für jede Unternehmensgröße') }}</h2>
            <p>{{ __('Starten Sie kostenlos und wachsen Sie mit Ihren Anforderungen.') }}</p>
        </div>
        <div class="plans">
            <div class="plan">
                <h3>Basis</h3>
                <div class="price">0€<small> / {{ __('Monat') }}</small></div>
                <ul>
                    <li>{{ __('Core: Dashboard, Dateien, Benachrichtigungen') }}</li>
                    <li>{{ __('Docs: Dokumente & Versionen') }}</li>
                    <li>{{ __('Library: Artikel & Vorlagen') }}</li>
                </ul>
                <a href="{{ route('register') }}" class="btn">{{ __('Kostenlos starten') }}</a>
            </div>
            <div class="plan hot">
                <span class="tag">{{ __('Beliebt') }}</span>
                <h3>Professional</h3>
                <div class="price">99€<small> / {{ __('Monat') }}</small></div>
                <ul>
                    <li>{{ __('Alles aus Basis') }}</li>
                    <li>{{ __('KI-Coach & Community') }}</li>
                    <li>{{ __('Score & Academy') }}</li>
                    <li>{{ __('Connect: Expertennetzwerk') }}</li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Jetzt starten') }}</a>
            </div>
            <div class="plan">
                <h3>Enterprise</h3>
                <div class="price">299€<small> / {{ __('Monat') }}</small></div>
                <ul>
                    <li>{{ __('Alles aus Professional') }}</li>
                    <li>{{ __('Creator & Exchange') }}</li>
                    <li>{{ __('MCP-API-Zugang') }}</li>
                    <li>{{ __('Priorisierter Support') }}</li>
                </ul>
                <a href="{{ route('register') }}" class="btn">{{ __('Kontakt aufnehmen') }}</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="cta-band">
            <h2>{{ __('Bereit für bessere Compliance?') }}</h2>
            <p>{{ __('Registrieren Sie Ihr Unternehmen in wenigen Minuten — keine Kreditkarte erforderlich.') }}</p>
            <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Jetzt kostenlos starten') }}</a>
        </div>
    </section>

    <footer class="foot">
        <div class="foot-inner">
            <div>
                <div class="f-brand"><span class="mark">C</span> COMPLYN</div>
                <p class="f-about">{{ __('Die modulare Compliance-Plattform für den deutschen Mittelstand — Dokumente, KI-Coach, Expertennetzwerk und Academy in einem System.') }}</p>
            </div>
            <div>
                <h4>{{ __('Plattform') }}</h4>
                <ul>
                    <li><a href="{{ route('register') }}">{{ __('Kostenlos starten') }}</a></li>
                    <li><a href="{{ route('login') }}">{{ __('Anmelden') }}</a></li>
                    <li><a href="#">{{ __('Tarife') }}</a></li>
                    <li><a href="#">{{ __('Funktionen') }}</a></li>
                </ul>
            </div>
            <div>
                <h4>{{ __('Unternehmen') }}</h4>
                <ul>
                    <li><a href="#">{{ __('Über uns') }}</a></li>
                    <li><a href="#">{{ __('Blog') }}</a></li>
                    <li><a href="#">{{ __('Kontakt') }}</a></li>
                </ul>
            </div>
            <div>
                <h4>{{ __('Rechtliches') }}</h4>
                <ul>
                    <li><a href="#">{{ __('Datenschutz') }}</a></li>
                    <li><a href="#">{{ __('Impressum') }}</a></li>
                    <li><a href="#">{{ __('AGB') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="foot-bottom">
            <span>© {{ date('Y') }} COMPLYN — {{ __('Compliance-Plattform für den Mittelstand') }}</span>
            <span class="lang-sw">
                <a href="{{ route('lang.switch', 'de') }}" class="{{ app()->getLocale() === 'de' ? 'on' : '' }}">DE</a>
                <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'on' : '' }}">EN</a>
            </span>
        </div>
    </footer>
</body>
</html>
