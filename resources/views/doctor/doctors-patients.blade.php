<x-app-layout>
    <x-slot name="header">
        {{ __("Visi gydytojai") }}
    </x-slot>

    <x-view-block>
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
                                {{ $user->start_time ? date("Y-m-d H:i", strtotime($user->start_time)) : "Galimo laiko nėra" }}
                            </x-table.td>
                            <x-table.td>
                                @if ($user->start_time)
                                    <x-table.view-link
                                        href="/doctor/{{$user->doctor_id}}/visit"
                                        class="text-blue-600 hover:text-blue-800 focus:text-blue-800"
                                    >
                                        Peržiūrėti laikus
                                    </x-table.view-link>
                                @else
                                    <x-table.view-link
                                        class="cursor-default text-gray-600 hover:text-gray-600"
                                    >
                                        Peržiūrėti laikus
                                    </x-table.view-link>
                                @endif
                            </x-table.td>
                        </tr>
                    @endforeach
                </x-slot>
                <x-slot:pagination>
                    {{ $users->links() }}
                </x-slot>
            </x-table.table>
        @else
            <x-table.empty-list>
                {{ __("Gydytoju sąrašas tuščias") }}
            </x-table.empty-list>
        @endif
    </x-view-block>
</x-app-layout>
