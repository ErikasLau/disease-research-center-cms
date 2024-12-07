<x-app-layout>
    <x-slot name="header">
        {{ __("Valdymo skydas") }}
    </x-slot>

    <x-view-block>
        <div class="grid grid-cols-4 gap-4">
            <x-admin-info-block>
                <x-slot name="count">
                    {{ $patients_count }}
                </x-slot>
                Pacientai
            </x-admin-info-block>

            <x-admin-info-block>
                <x-slot name="count">
                    {{ $doctors_count }}
                </x-slot>
                Gydytojai
            </x-admin-info-block>

            <x-admin-info-block>
                <x-slot name="count">
                    {{ $laboratorians_count }}
                </x-slot>
                Laborantai
            </x-admin-info-block>

            <x-admin-info-block>
                <x-slot name="count">
                    {{ $admins_count }}
                </x-slot>
                Administratoriai
            </x-admin-info-block>

            <x-admin-info-block>
                <x-slot name="count">
                    {{ $visits_count }}
                </x-slot>
                Vizitai
            </x-admin-info-block>

            <x-admin-info-block>
                <x-slot name="count">
                    {{ $examinations_count }}
                </x-slot>
                Tyrimai
            </x-admin-info-block>

            <x-admin-info-block>
                <x-slot name="count">
                    {{ $results_count }}
                </x-slot>
                Rezultatai
            </x-admin-info-block>
        </div>
    </x-view-block>
</x-app-layout>
