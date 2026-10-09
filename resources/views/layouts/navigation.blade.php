<aside class="w-64 h-full bg-slate-900 border-r border-slate-800 flex flex-col">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-5 h-16 border-b border-slate-800 shrink-0">
        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-amber-500 text-slate-900 font-extrabold text-sm">C</span>
        <span class="text-white font-bold tracking-tight">COMPLYN</span>
    </a>

    @php
        $user = auth()->user();
        $pillars = config('blocks.pillars', []);
        $blocks = collect(config('blocks.blocks', []))->sortBy('order');
        $routeMap = [
            'core' => 'files.index',
            'docs' => 'docs.index',
            'coach' => 'coach.index',
            'community' => 'community.index',
            'score' => 'score.index',
            'connect' => 'connect.index',
            'library' => 'library.index',
            'creator' => 'creator.index',
            'academy' => 'academy.index',
            'exchange' => 'exchange.index',
        ];
        $icons = [
            'core' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
            'docs' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
            'coach' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
            'community' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
            'score' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
            'connect' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1',
            'library' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
            'creator' => 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z',
            'academy' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222',
            'exchange' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4',
        ];
        $subRoutes = [
            'core' => [
                'core.obligations' => 'Pflichtenkalender',
                'core.deadlines' => 'Fristen',
                'core.tasks' => 'Aufgaben',
                'core.evidences' => 'Nachweise',
                'files.index' => 'Dateien',
                'settings' => 'Einstellungen',
            ],
            'coach' => [
                'coach.recommendations' => 'Empfehlungen',
                'coach.analysis' => 'Analyse',
                'coach.index' => 'KI-Coach',
            ],
            'score' => [
                'score.index' => 'Übersicht',
                'score.leaderboard' => 'Rangliste',
            ],
            'connect' => [
                'connect.index' => 'Anfragen',
                'connect.experts' => 'Experten',
            ],
            'exchange' => [
                'exchange.index' => 'Marktplatz',
                'exchange.groups' => 'Fachgruppen',
            ],
            'academy' => [
                'academy.index' => 'Kurse',
            ],
        ];
        $locale = app()->getLocale();
    @endphp

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-5">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-amber-500 text-slate-900 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"/></svg>
            {{ __('Dashboard') }}
        </a>
        <a href="{{ route('notifications.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('notifications.*') ? 'bg-amber-500 text-slate-900 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            {{ __('Benachrichtigungen') }}
        </a>

        @foreach($pillars as $pillarKey => $pillar)
            @php
                $pillarBlocks = $blocks->filter(fn($b) => ($b['pillar'] ?? null) === $pillarKey && companyHasBlock($user, $blocks->search($b)));
            @endphp
            @continue($pillarBlocks->isEmpty())
            <div x-data="{ open: {{ $pillarBlocks->keys()->contains(fn($k) => request()->routeIs(($routeMap[$k] ?? 'x').'*') || request()->routeIs(strtok(($routeMap[$k] ?? 'x'), '.').'.*')) ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2 text-xs font-semibold uppercase tracking-wider text-slate-500 hover:text-slate-300 transition">
                    <span>{{ $pillar[$locale] ?? $pillar['de'] }}</span>
                    <svg :class="open ? 'rotate-180' : ''" class="h-3.5 w-3.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse class="mt-1 space-y-0.5">
                    @foreach($pillarBlocks as $blockKey => $block)
                        @php $routeName = $routeMap[$blockKey] ?? null; @endphp
                        @continue(!$routeName || !Route::has($routeName))
                        @php $active = request()->routeIs($routeName) || request()->routeIs($blockKey.'.*'); @endphp
                        <a href="{{ route($routeName) }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition {{ $active ? 'bg-slate-800 text-amber-400 font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="h-4.5 w-4.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$blockKey] ?? 'M4 6h16M4 12h16M4 18h16' }}"/></svg>
                            {{ $block['name'][$locale] ?? $block['name']['de'] ?? $blockKey }}
                        </a>
                        @if($active && isset($subRoutes[$blockKey]))
                            @foreach($subRoutes[$blockKey] as $sr => $sl)
                                @continue(!Route::has($sr))
                                <a href="{{ route($sr) }}" class="ml-8 flex items-center px-3 py-1.5 rounded-lg text-xs transition {{ request()->routeIs($sr) ? 'text-amber-400 font-semibold' : 'text-slate-500 hover:text-white' }}">{{ __($sl) }}</a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach

        @if($user->is_platform_admin)
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.*') ? 'bg-amber-500 text-slate-900 font-semibold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ __('Administration') }}
            </a>
        @endif
    </nav>

    <div class="border-t border-slate-800 p-3 shrink-0 space-y-1">
        <div class="flex items-center rounded-lg border border-slate-700 text-xs font-semibold overflow-hidden">
            <a href="{{ route('lang.switch', 'de') }}" class="flex-1 text-center py-1.5 {{ $locale === 'de' ? 'bg-amber-500 text-slate-900' : 'text-slate-400 hover:text-white' }}">DE</a>
            <a href="{{ route('lang.switch', 'en') }}" class="flex-1 text-center py-1.5 {{ $locale === 'en' ? 'bg-amber-500 text-slate-900' : 'text-slate-400 hover:text-white' }}">EN</a>
        </div>
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 transition">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-500/15 text-amber-400 font-bold text-xs shrink-0">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            <span class="min-w-0">
                <span class="block text-sm font-medium text-white truncate">{{ $user->name }}</span>
                <span class="block text-xs text-slate-500 truncate">{{ $user->email }}</span>
            </span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</aside>
