<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $title ?? 'Admin' }}
            </h2>
            <nav class="flex gap-4 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-500">Dashboard</a>
                <a href="{{ route('admin.companies') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-500">Unternehmen</a>
                <a href="{{ route('admin.users') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-500">Benutzer</a>
                <a href="{{ route('admin.plans') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-500">Tarife</a>
                <a href="{{ route('admin.modules') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-500">Module</a>
                <a href="{{ route('admin.taxonomy') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-500">Taxonomie</a>
                <a href="{{ route('admin.mcp.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-500">MCP</a>
                <a href="{{ route('admin.audit') }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-500">Audit-Log</a>
            </nav>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-4 py-2 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</x-app-layout>
