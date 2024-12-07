<x-app-layout>
    <x-slot name="header">
        {{ __("Gydytojai") }}
    </x-slot>

    <x-view-block>
        @if (count($doctors) > 0)
            <div x-data="{ selectedDoctor: null, selectedDoctorId: null }">
                <x-success-message />
                <x-create-button href="/doctor/create">
                    Sukurti naują
                </x-create-button>
                <x-table.table>
                    <x-slot:thead>
                        <x-table.th>Gydytojas</x-table.th>
                        <x-table.th>Licencijos numeris</x-table.th>
                        <x-table.th>Specializacija</x-table.th>
                        <x-table.th>Sukūrimo data</x-table.th>
                        <x-table.th>Veiksmai</x-table.th>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($doctors as $doctor)
                            <tr class="hover:bg-gray-100">
                                <x-table.td>
                                    {{ $doctor->user->name }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $doctor->licence_number }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $doctor->specialization->name }}
                                </x-table.td>
                                <x-table.td>
                                    {{ date("Y-m-d H:i", strtotime($doctor->created_at)) }}
                                </x-table.td>
                                <x-table.td>
                                    <div
                                        @click.prevent="
                                                          $dispatch('open-modal', 'confirm-deletion');
                                                          selectedDoctor = @js($doctor->user);
                                                          selectedDoctorId = @js($doctor->id);
                                                      "
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
                        {{ $doctors->links() }}
                    </x-slot>
                </x-table.table>
                <x-modal name="confirm-deletion" focusable>
                    <form method="post" action="/doctor" class="p-6">
                        @csrf
                        @method("delete")

                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __("Ar tikrai norite pašalinti gydytoją") }}
                            <span
                                class="font-semibold"
                                x-text="selectedDoctor ? selectedDoctor.name : ''"
                            ></span>
                            ?
                        </h2>

                        <input
                            id="id"
                            name="id"
                            x-model="selectedDoctorId"
                            type="hidden"
                        />

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Kai paskyra bus ištrinta, visi jos ištekliai ir duomenys bus ištrinti visam laikui. Įveskite slaptažodį, kad patvirtintumėte, jog norite visam laikui ištrinti paskyrą.") }}
                        </p>

                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __("Atšaukti") }}
                            </x-secondary-button>

                            <x-danger-button class="ms-3">
                                {{ __("Ištrinti") }}
                            </x-danger-button>
                        </div>
                    </form>
                </x-modal>
            </div>
        @else
            <x-table.empty-list>
                {{ __("Gydytoju sąrašas tuščias") }}
            </x-table.empty-list>
        @endif
    </x-view-block>
</x-app-layout>
