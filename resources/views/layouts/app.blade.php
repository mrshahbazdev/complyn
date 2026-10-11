<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>COMPLYN</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/uikit.css') }}">
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body>
        <div class="app">
            @include('layouts.navigation')

            <div class="sidebar-overlay" id="sideOverlay" onclick="document.getElementById('appSidebar').classList.remove('open');this.classList.remove('show')"></div>

            <div class="main">
                <header class="topbar">
                    <div class="topbar-inner">
                        <button class="menu-btn" aria-label="{{ __('Menü öffnen') }}" onclick="document.getElementById('appSidebar').classList.toggle('open');document.getElementById('sideOverlay').classList.toggle('show')">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <a href="{{ route('dashboard') }}" class="mini-brand"><span class="logo-mark">C</span>COMPLYN</a>
                        @isset($header)
                            <nav class="crumbs"><a href="{{ route('dashboard') }}">{{ __('Start') }}</a><span>›</span><b>{{ $header }}</b></nav>
                        @endisset
                        <form action="{{ route('search') }}" method="GET" class="search">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input name="q" value="{{ request('q') }}" placeholder="{{ __('Dokumente, Aufgaben, Experten suchen…') }}">
                        </form>
                        <div class="top-actions">
                            <a href="{{ route('notifications.index') }}" class="icon-btn" aria-label="{{ __('Benachrichtigungen') }}">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            </a>
                            @if (Route::has('docs.create'))
                                <a href="{{ route('docs.create') }}" class="btn btn-dark btn-new-doc">
                                    <svg fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    {{ __('Neues Dokument') }}
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="avatar" style="height:40px;width:40px;text-decoration:none;">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</a>
                        </div>
                    </div>
                </header>

                <main class="content">
                    {{ $slot }}
                </main>
            </div>
        </div>
        
    </body>
</html>
