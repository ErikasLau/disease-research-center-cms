<x-app-layout>
    <x-slot name="header">
        {{ __("Mano vizitai") }}
    </x-slot>

    <x-view-block>
        @if (count($visits) > 0)
            <x-table.table>
                <x-slot:thead>
                    <x-table.th>Gydytojas</x-table.th>
                    <x-table.th>Vizito laikas</x-table.th>
                    <x-table.th>Statusas</x-table.th>
                    <x-table.th>Turi tyrimą</x-table.th>
                    <x-table.th>Veiksmai</x-table.th>
                </x-slot>
                <x-slot:tbody>
                    @foreach ($visits as $visit)
                        <tr class="hover:bg-gray-100">
                            <x-table.td>
                                {{ $visit->doctor->user->name }}
                            </x-table.td>
                            <x-table.td>
                                {{ $visit->visit_date }}
                            </x-table.td>
                            <x-table.td>
                                {{ __("page.visitStatus." . $visit->status) }}
                            </x-table.td>
                            <x-table.td>
                                {{ $visit->examination ? "Turi" : "Neturi" }}
                            </x-table.td>
                            <x-table.td>
                                <x-table.view-link
                                    href="/visit/{{ $visit->id }}"
                                >
                                    Peržiūrėti
                                </x-table.view-link>
                            </x-table.td>
                        </tr>
                    @endforeach
                </x-slot>
                <x-slot:pagination>
                    {{ $visits->links() }}
                </x-slot>
            </x-table.table>
        @else
            <x-table.empty-list>Vizitų istorija tuščia</x-table.empty-list>
        @endif
    </x-view-block>
</x-app-layout>
