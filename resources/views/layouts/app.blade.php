<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>COMPLYN</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-slate-50" x-data="{ sidebarOpen: false }">
            <div class="hidden lg:block fixed inset-y-0 left-0 z-40">
                @include('layouts.navigation')
            </div>

            <div class="lg:pl-64 flex flex-col min-h-screen">
                <!-- Mobile topbar -->
                <div class="lg:hidden sticky top-0 z-30 bg-slate-900 border-b border-slate-800 h-14 flex items-center px-4 gap-3">
                    <button @click="sidebarOpen = true" class="p-2 -ms-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-500 text-slate-900 font-extrabold text-xs">C</span>
                        <span class="text-white font-bold text-sm">COMPLYN</span>
                    </a>
                </div>

                <!-- Mobile sidebar overlay -->
                <div x-show="sidebarOpen" class="lg:hidden" style="display:none">
                    <div class="fixed inset-0 z-40 bg-slate-950/60" @click="sidebarOpen = false"></div>
                    <div class="fixed inset-y-0 left-0 z-50 w-64" @keydown.escape.window="sidebarOpen = false" @click="if ($event.target.closest('a')) sidebarOpen = false">
                        @include('layouts.navigation')
                    </div>
                </div>

                @isset($header)
                    <header class="bg-white border-b border-slate-200">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
