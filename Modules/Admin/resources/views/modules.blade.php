<x-admin::layout>
    <x-slot:title>{{ __("Module") }}</x-slot:title>

    @foreach ($modules as $blockKey => $mods)
        <div class="card fade-up" style="padding:20px 24px">
            <h3 class="panel-h">
                {{ $blocks[$blockKey]['name']['de'] ?? $blockKey }}
                <span>({{ $blockKey }})</span>
            </h3>
            <table class="docs">
                @foreach ($mods as $m)
                    <tr class="last:border-0">
                        <td>{{ $m->key }}</td>
                        <td class="muted">{{ $m->name }}</td>
                        <td class="muted">{{ $m->version }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.modules.update', $m) }}" class="inline-flex">
                                @csrf @method('PUT')
                                @foreach (['enabled', 'disabled', 'deprecated'] as $s)
                                    <button name="status" value="{{ $s }}" class="{{ $m->status === $s ? 'badge blue border-indigo-600' : 'border-gray-300 text-gray-500' }}">{{ $s }}</button>
                                @endforeach
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
</x-admin::layout>
