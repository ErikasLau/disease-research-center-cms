<x-app-layout>
    <x-slot name="header">
        {{ __("Pacientai") }}
    </x-slot>

    <x-view-block>
        @if (count($patients) > 0)
            <div x-data="{ selectedPatient: null, selectedPatientId: null }">
                <x-success-message />
                <x-table.table>
                    <x-slot:thead>
                        <x-table.th>Pacientas</x-table.th>
                        <x-table.th>El. paštas</x-table.th>
                        <x-table.th>Tel. numeris</x-table.th>
                        <x-table.th>Sukūrimo data</x-table.th>
                        <x-table.th>Veiksmai</x-table.th>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($patients as $patient)
                            <tr class="hover:bg-gray-100">
                                <x-table.td>
                                    {{ $patient->user->name }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $patient->user->email }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $patient->user->phone_number }}
                                </x-table.td>
                                <x-table.td>
                                    {{ date("Y-m-d H:i", strtotime($patient->created_at)) }}
                                </x-table.td>
                                <x-table.td>
                                    <div
                                        @click.prevent=" $dispatch('open-modal',
                                'confirm-deletion'); selectedPatient =
                                @js($patient->user)
                                ; selectedPatientId =
                                @js($patient->id)
                                ; "
                                    >
                                        <x-table.delete-button>
                                            Ištrinti
                                        </x-table.delete-button>
                                    </div>
                                </x-table.td>
                            </tr>
                        @endforeach
                    </x-slot>
                    <x-slot:pagination>
                        {{ $patients->links() }}
                    </x-slot>
                </x-table.table>
                @include("patient.partials.delete-modal")
            </div>
        @else
            <x-table.empty-list>
                {{ __("Pacientų sąrašas tuščias") }}
            </x-table.empty-list>
        @endif
    </x-view-block>
</x-app-layout>
