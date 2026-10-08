<x-admin::layout>
    <x-slot:title>Module</x-slot:title>

    @foreach ($modules as $blockKey => $mods)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
            <h3 class="font-semibold mb-3 text-gray-900 dark:text-gray-100">
                {{ $blocks[$blockKey]['name']['de'] ?? $blockKey }}
                <span class="text-xs text-gray-500 font-normal">({{ $blockKey }})</span>
            </h3>
            <table class="w-full text-sm">
                @foreach ($mods as $m)
                    <tr class="border-b dark:border-gray-700 last:border-0">
                        <td class="py-2 text-gray-800 dark:text-gray-200">{{ $m->key }}</td>
                        <td class="text-gray-600 dark:text-gray-300">{{ $m->name }}</td>
                        <td class="text-gray-500 text-xs">{{ $m->version }}</td>
                        <td class="text-right">
                            <form method="POST" action="{{ route('admin.modules.update', $m) }}" class="inline-flex gap-1">
                                @csrf @method('PUT')
                                @foreach (['enabled', 'disabled', 'deprecated'] as $s)
                                    <button name="status" value="{{ $s }}" class="px-2 py-1 rounded text-xs border {{ $m->status === $s ? 'bg-indigo-600 text-white border-indigo-600' : 'border-gray-300 text-gray-500' }}">{{ $s }}</button>
                                @endforeach
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
</x-admin::layout>
