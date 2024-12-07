<x-app-layout>
    <x-slot name="header">
        {{ __("Valdymo skydas") }}
    </x-slot>

    <x-view-block>
        @if (count($examinations) > 0)
            <div class="mb-4 border-b-2 border-gray-300 pb-2">
                <h2
                    class="text-xl font-semibold uppercase leading-7 text-gray-900"
                >
                    Pacientų tyrimai
                </h2>
            </div>
            <x-table.table>
                <x-slot:thead>
                    <x-table.th>Pacientas</x-table.th>
                    <x-table.th>Statusas</x-table.th>
                    <x-table.th>Tyrimo tipas</x-table.th>
                    <x-table.th>Sukūrimo laikas</x-table.th>
                    <x-table.th>Veiksmai</x-table.th>
                </x-slot>
                <x-slot:tbody>
                    @foreach ($examinations as $examination)
                        <tr class="hover:bg-gray-100">
                            <x-table.td>
                                {{ $examination->patient ? $examination->patient->user->name : "Pašalintas" }}
                            </x-table.td>
                            <x-table.td>
                                {{ __("page.examinationStatus." . $examination->status) }}
                            </x-table.td>
                            <x-table.td>
                                {{ $examination->type }}
                            </x-table.td>
                            <x-table.td>
                                {{ $examination->created_at }}
                            </x-table.td>
                            <x-table.td>
                                <x-table.view-link
                                    href="/examination/{{ $examination->id }}"
                                >
                                    Peržiūrėti
                                </x-table.view-link>
                            </x-table.td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table.table>
            <div class="mt-2 text-right">
                <x-primary-button href="/examinations">
                    Visi tyrimai
                </x-primary-button>
            </div>
        @else
            <x-table.empty-list>
                {{ __("Pacientų tyrimų nėra") }}
            </x-table.empty-list>
        @endif
    </x-view-block>
</x-app-layout>
