<x-admin::layout>
    <x-slot:title>{{ __("Benutzer") }}</x-slot:title>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
        <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">{{ __("Neuer Benutzer") }}</h3>
        <form method="POST" action="{{ route('admin.users.store') }}" class="flex flex-wrap gap-3 items-end">
            @csrf
            <input name="name" placeholder="Name" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <input name="email" type="email" placeholder="E-Mail" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <input name="password" type="password" placeholder="Passwort" required class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
            <select name="company_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                <option value="">{{ __("— Unternehmen —") }}</option>
                @foreach ($companies as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
            </select>
            <select name="role" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                <option value="member">{{ __("member") }}</option><option value="admin">{{ __("admin") }}</option><option value="owner">{{ __("owner") }}</option>
            </select>
            <label class="text-sm text-gray-600 dark:text-gray-300"><input type="checkbox" name="is_platform_admin" value="1"> Plattform-Admin</label>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded">Anlegen</button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5" x-data="{ attach: null }">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 border-b dark:border-gray-700">
                <th class="py-2">{{ __("Name") }}</th><th>{{ __("E-Mail") }}</th><th>{{ __("Unternehmen") }}</th><th>{{ __("Admin") }}</th><th></th>
            </tr></thead>
            <tbody>
            @foreach ($users as $u)
                <tr class="border-b dark:border-gray-700">
                    <td class="py-2 text-gray-800 dark:text-gray-200">{{ $u->name }}</td>
                    <td class="text-gray-600 dark:text-gray-300">{{ $u->email }}</td>
                    <td class="text-gray-600 dark:text-gray-300">
                        {{ $u->companies->map(fn($c) => $c->name.' ('.$c->pivot->role.')')->join(', ') }}
                        <button @click="attach = attach === {{ $u->id }} ? null : {{ $u->id }}" class="text-indigo-500 text-xs ml-1">+</button>
                    </td>
                    <td class="text-gray-600 dark:text-gray-300">{{ $u->is_platform_admin ? '✓' : '' }}</td>
                    <td class="text-right">
                        <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Löschen?')" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-xs">{{ __("Löschen") }}</button>
                        </form>
                    </td>
                </tr>
                <tr x-show="attach === {{ $u->id }}" x-cloak>
                    <td colspan="5" class="py-2 bg-gray-50 dark:bg-gray-900">
                        <form method="POST" action="{{ route('admin.users.attach', $u) }}" class="flex gap-2 items-center">
                            @csrf
                            <select name="company_id" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                                @foreach ($companies as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                            </select>
                            <select name="role" class="rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200 text-sm">
                                <option value="member">{{ __("member") }}</option><option value="admin">{{ __("admin") }}</option><option value="owner">{{ __("owner") }}</option>
                            </select>
                            <button class="bg-indigo-600 text-white px-3 py-1 rounded text-xs">Zuordnen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</x-admin::layout>
