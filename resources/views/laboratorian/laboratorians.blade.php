<x-app-layout>
    <x-slot name="header">
        {{ __("Laborantai") }}
    </x-slot>

    <x-view-block>
        @if (count($users) > 0)
            <div x-data="{ selectedUser: null, selectedUserId: null }">
                <x-success-message />
                <span class="sm:ml-3">
                    <x-create-button href="/laboratorian/create">
                        Sukurti naują
                    </x-create-button>
                </span>
                <x-table.table>
                    <x-slot:thead>
                        <x-table.th>Laborantas</x-table.th>
                        <x-table.th>El. paštas</x-table.th>
                        <x-table.th>Tel. numeris</x-table.th>
                        <x-table.th>Sukūrimo data</x-table.th>
                        <x-table.th>Veiksmai</x-table.th>
                    </x-slot>
                    <x-slot:tbody>
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-100">
                                <x-table.td>
                                    {{ $user->name }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $user->email }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $user->phone_number }}
                                </x-table.td>
                                <x-table.td>
                                    {{ date("Y-m-d H:i", strtotime($user->created_at)) }}
                                </x-table.td>
                                <x-table.td>
                                    <div
                                        @click.prevent="
                                                          $dispatch('open-modal', 'confirm-deletion');
                                                          selectedUser = @js($user);
                                                          selectedUserId = @js($user->id);
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
                        {{ $users->links() }}
                    </x-slot>
                </x-table.table>
                @include("laboratorian.partials.delete-modal")
            </div>
        @else
            <x-table.empty-list>
                {{ __("Laborantų sąrašas tuščias") }}
            </x-table.empty-list>
        @endif
    </x-view-block>
</x-app-layout>
