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
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Brand panel -->
            <div class="hidden lg:flex lg:w-[45%] flex-col justify-between bg-slate-900 p-12 text-white">
                <div>
                    <a href="/" class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-slate-900 font-extrabold text-lg">C</span>
                        <span class="text-xl font-bold tracking-tight">COMPLYN</span>
                    </a>
                    <h1 class="mt-16 text-3xl font-bold leading-tight max-w-md">
                        {{ __('Compliance-Plattform für den Mittelstand') }}
                    </h1>
                    <p class="mt-4 text-slate-400 max-w-md leading-relaxed">
                        {{ __('Dokumentation, Nachverfolgung und Bewertung von Compliance — mit KI-Unterstützung, modular aufgebaut.') }}
                    </p>
                </div>
                <div class="space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10">
                            <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">{{ __('Modulare Bausteine') }}</div>
                            <div class="text-sm text-slate-400">{{ __('Nur aktivieren, was Ihr Plan enthält — 10 Blöcke, 60 Module.') }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10">
                            <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">{{ __('KI-gestützte Analyse') }}</div>
                            <div class="text-sm text-slate-400">{{ __('Coach, Bewertung und Dokumenterstellung inklusive.') }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10">
                            <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">{{ __('DSGVO-konform') }}</div>
                            <div class="text-sm text-slate-400">{{ __('Datenhoheit in Deutschland, vollständiges Audit-Log.') }}</div>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-slate-500">© {{ date('Y') }} COMPLYN — DISAVO</p>
            </div>

            <!-- Form panel -->
            <div class="flex flex-1 flex-col justify-center items-center bg-slate-50 px-6 py-12 relative">
                <div class="absolute top-6 right-6 flex items-center rounded-lg border border-slate-200 bg-white text-xs font-semibold overflow-hidden">
                    <a href="{{ route('lang.switch', 'de') }}" class="px-2.5 py-1.5 {{ app()->getLocale() === 'de' ? 'bg-amber-500 text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">DE</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1.5 {{ app()->getLocale() === 'en' ? 'bg-amber-500 text-slate-900' : 'text-slate-500 hover:text-slate-900' }}">EN</a>
                </div>
                <a href="/" class="lg:hidden flex items-center gap-2 mb-8">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500 text-slate-900 font-extrabold">C</span>
                    <span class="text-lg font-bold text-slate-900">COMPLYN</span>
                </a>
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
