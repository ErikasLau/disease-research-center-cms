<x-app-layout>
    <x-slot name="header">
        {{ __("Tyrimai") }}
    </x-slot>

    <x-view-block>
        @if (count($examinations) > 0)
            <x-table.table>
                <x-slot:thead>
                    <x-table.th>Pacientas</x-table.th>
                    <x-table.th>Tyrimo tipas</x-table.th>
                    <x-table.th>Statusas</x-table.th>
                    <x-table.th>Pateikti rezultatai</x-table.th>
                    <x-table.th>Sukūrimo data</x-table.th>
                    <x-table.th>Veiksmai</x-table.th>
                </x-slot>
                <x-slot:tbody>
                    @foreach ($examinations as $examination)
                        <tr class="hover:bg-gray-100">
                            <x-table.td>
                                {{ $examination->patient->user->name }}
                            </x-table.td>
                            <x-table.td>
                                {{ $examination->type }}
                            </x-table.td>
                            <x-table.td>
                                {{ __("page.examinationStatus." . $examination->status) }}
                            </x-table.td>
                            <x-table.td>
                                {{ $examination->result ? "Taip" : "Ne" }}
                            </x-table.td>
                            <x-table.td>
                                {{ date("Y-m-d H:i", strtotime($examination->created_at)) }}
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
                <x-slot:pagination>
                    {{ $examinations->links() }}
                </x-slot>
            </x-table.table>
        @else
            <x-table.empty-list>
                {{ __("Tyrimų istorija tuščia") }}
            </x-table.empty-list>
        @endif
    </x-view-block>
</x-app-layout>
