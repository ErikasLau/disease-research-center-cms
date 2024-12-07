<x-app-layout>
    <x-slot name="header">
        {{ __("Valdymo skydas") }}
    </x-slot>

    <x-view-block>
        <div class="mb-4">
            <div class="mb-4 border-b-2 border-gray-300 pb-2">
                <h2
                    class="text-xl font-semibold uppercase leading-7 text-gray-900"
                >
                    Būsimi vizitai
                </h2>
            </div>
            @if (count($createdVisits) > 0)
                <div
                    class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
                >
                    @foreach ($createdVisits as $visit)
                        <x-visit-info-block :visit="$visit" />
                    @endforeach
                </div>
            @else
                <div class="my-8 text-center">Būsimų vizitų nėra</div>
            @endif
        </div>
        <div>
            <div class="mb-4 border-b-2 border-gray-300 pb-2">
                <h2
                    class="text-xl font-semibold uppercase leading-7 text-gray-900"
                >
                    Praėję vizitai
                </h2>
            </div>
            @if (count($completedVisits) > 0)
                <div
                    class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
                >
                    @foreach ($completedVisits as $visit)
                        <x-visit-info-block :visit="$visit" />
                    @endforeach
                </div>
                <div class="mt-3 text-right">
                    <a href="/patient/treatment-history/visits">
                        <x-primary-button>Visi vizitai</x-primary-button>
                    </a>
                </div>
            @else
                <div class="my-8 text-center">Praėjusių vizitų nėra</div>
            @endif
        </div>
    </x-view-block>

    <x-view-block class="mt-4">
        <div class="mb-4 border-b-2 border-gray-300 pb-2">
            <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
                Registracija pas gydytojus
            </h2>
        </div>
        @if (count($users) > 0)
            <x-table.table>
                <x-slot:thead>
                    <x-table.th>Gydytojas</x-table.th>
                    <x-table.th>Specializacija</x-table.th>
                    <x-table.th>Artimiausias laikas</x-table.th>
                    <x-table.th>Veiksmai</x-table.th>
                </x-slot>
                <x-slot:tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-100">
                            <x-table.td>
                                {{ $user->name }}
                            </x-table.td>
                            <x-table.td>
                                {{ $user->specialization_name }}
                            </x-table.td>
                            <x-table.td>
                                {{ date("Y-m-d H:i", strtotime($user->start_time)) }}
                            </x-table.td>
                            <x-table.td>
                                <x-table.view-link
                                    href="/doctor/{{ $user->doctor_id }}/visit"
                                >
                                    Peržiūrėti laikus
                                </x-table.view-link>
                            </x-table.td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table.table>
            <div class="mt-3 text-right">
                <x-primary-button href="/doctors">
                    Visi gydytojai
                </x-primary-button>
            </div>
        @endif
    </x-view-block>
</x-app-layout>
