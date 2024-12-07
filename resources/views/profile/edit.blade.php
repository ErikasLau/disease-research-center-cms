<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Paskyra") }}
        </h2>
    </x-slot>

    <x-view-block>
        @include("profile.partials.update-profile-information-form")
    </x-view-block>

    <x-view-block class="mt-4">
        @include("profile.partials.update-password-form")
    </x-view-block>

    <x-view-block class="mt-4">
        @include("profile.partials.delete-user-form")
    </x-view-block>
</x-app-layout>
