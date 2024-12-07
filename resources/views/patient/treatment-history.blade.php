<x-app-layout>
    <x-slot name="header">
        {{ __("Gydymo istorija") }}
    </x-slot>

    @if (count($visits) > 0)
        <x-view-block>
            <x-title>Vizitai</x-title>
            <div
                class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
            >
                @foreach ($visits as $visit)
                    <x-visit-info-block :visit="$visit" />
                @endforeach
            </div>
            <div class="mt-2 text-right">
                <a href="/patient/treatment-history/visits">
                    <x-primary-button>Visi vizitai</x-primary-button>
                </a>
            </div>
        </x-view-block>
    @endif

    @if (count($examinations) > 0)
        <x-view-block class="mt-4">
            <x-title>Tyrimai</x-title>
            <div
                class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
            >
                @foreach ($examinations as $examination)
                    <x-examination-info-block :examination="$examination" />
                @endforeach
            </div>
            <div class="mt-2 text-right">
                <x-primary-button
                    href="/patient/treatment-history/examinations"
                >
                    Visi tyrimai
                </x-primary-button>
            </div>
        </x-view-block>
    @endif

    @if (! ($visits && $examinations))
        <x-view-block>
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-center text-gray-900">
                    Jūsų gydymo istorija yra tuščia
                </div>
            </div>
        </x-view-block>
    @endif
</x-app-layout>
