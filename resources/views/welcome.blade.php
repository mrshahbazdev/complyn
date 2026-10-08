<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('app.platform_name') }} — {{ __('app.tagline') }}</title>
    <style>
        :root { color-scheme: dark; }
        body { margin: 0; font-family: system-ui, sans-serif; background: #0f172a; color: #e2e8f0;
               display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .card { text-align: center; }
        h1 { font-size: 3rem; letter-spacing: .2em; margin: 0 0 .5rem; color: #38bdf8; }
        p { color: #94a3b8; }
        .badge { display: inline-block; margin-top: 1rem; padding: .35rem .9rem; border: 1px solid #334155;
                 border-radius: 999px; font-size: .8rem; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="card">
        <h1>{{ __('app.platform_name') }}</h1>
        <p>{{ __('app.tagline') }}</p>
        <span class="badge">Phase 0 — Platform Foundation</span>
    </div>
</body>
</html>
