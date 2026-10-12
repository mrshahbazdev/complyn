<x-app-layout>
    <x-slot name="header">
        <h2>{{ __('Profile') }}</h2>
    </x-slot>

    <div class="stack">
        <div class="card fade-up"><div class="panel-body">
            @include('profile.partials.update-profile-information-form')
        </div></div>

        <div class="card fade-up"><div class="panel-body">
            @include('profile.partials.update-password-form')
        </div></div>

        <div class="card fade-up"><div class="panel-body">
            @include('profile.partials.delete-user-form')
        </div></div>
    </div>
</x-app-layout>
