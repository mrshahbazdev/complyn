<x-admin::layout>
    <x-slot:title>{{ __("Benutzer") }}</x-slot:title>

    <div class="card fade-up" style="padding:20px 24px">
        <h3 class="panel-h">{{ __("Neuer Benutzer") }}</h3>
        <form method="POST" action="{{ route('admin.users.store') }}" class="gap-3">
            @csrf
            <input name="name" placeholder="{{ __('Name') }}" required class="field-input">
            <input name="email" type="email" placeholder="{{ __('E-Mail') }}" required class="field-input">
            <input name="password" type="password" placeholder="{{ __('Passwort') }}" required class="field-input">
            <select name="company_id" class="field-input">
                <option value="">{{ __("— Unternehmen —") }}</option>
                @foreach ($companies as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
            </select>
            <select name="role" class="field-input">
                <option value="member">{{ __("member") }}</option><option value="admin">{{ __("admin") }}</option><option value="owner">{{ __("owner") }}</option>
            </select>
            <label class="muted"><input type="checkbox" name="is_platform_admin" value="1"> Plattform-Admin</label>
            <button class="btn btn-brand">Anlegen</button>
        </form>
    </div>

    <div class="card fade-up" style="padding:20px 24px" x-data="{ attach: null }">
        <table class="docs">
            <thead><tr>
                <th>{{ __("Name") }}</th><th>{{ __("E-Mail") }}</th><th>{{ __("Unternehmen") }}</th><th>{{ __("Admin") }}</th><th></th>
            </tr></thead>
            <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td class="muted">{{ $u->email }}</td>
                    <td class="muted">
                        {{ $u->companies->map(fn($c) => $c->name.' ('.$c->pivot->role.')')->join(', ') }}
                        <button @click="attach = attach === {{ $u->id }} ? null : {{ $u->id }}" class="flink">+</button>
                    </td>
                    <td class="muted">{{ $u->is_platform_admin ? '✓' : '' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Löschen?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline btn-sm" style="color:#dc2626">{{ __("Löschen") }}</button>
                        </form>
                    </td>
                </tr>
                <tr x-show="attach === {{ $u->id }}" x-cloak>
                    <td colspan="5">
                        <form method="POST" action="{{ route('admin.users.attach', $u) }}" class="gap-2 items-center">
                            @csrf
                            <select name="company_id" class="field-input">
                                @foreach ($companies as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                            </select>
                            <select name="role" class="field-input">
                                <option value="member">{{ __("member") }}</option><option value="admin">{{ __("admin") }}</option><option value="owner">{{ __("owner") }}</option>
                            </select>
                            <button class="btn btn-brand btn-sm">Zuordnen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</x-admin::layout>
