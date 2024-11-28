@php
    use App\Models\Doctor;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    $doctors = Doctor::orderBy("created_at", "DESC")->paginate(15);
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Gydytojai") }}
        </h2>
    </x-slot>

    <div x-data="{ selectedDoctor: null, selectedDoctorId: null }">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <x-success-message />
                        <span class="sm:ml-3">
                            <a href="/doctor/create" class="sm:ml-3">
                                <button
                                    type="button"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                >
                                    Sukurti naują
                                </button>
                            </a>
                        </span>
                        <div class="flex flex-col">
                            <div class="-m-1.5 overflow-x-auto">
                                <div
                                    class="inline-block min-w-full p-1.5 align-middle"
                                >
                                    <div class="overflow-hidden">
                                        <table
                                            class="min-w-full divide-y divide-gray-200"
                                        >
                                            <thead>
                                                <tr>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Gydytojas
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Licencijos numeris
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Specializacija
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Sukūrimo data
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Veiksmai
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="divide-y divide-gray-200"
                                            >
                                                @foreach ($doctors as $doctor)
                                                    <tr
                                                        class="hover:bg-gray-100"
                                                    >
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-800"
                                                        >
                                                            {{ $doctor->user->name }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ $doctor->licence_number }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ $doctor->specialization->name }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ date("Y-m-d H:i", strtotime($doctor->created_at)) }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-start text-sm font-medium"
                                                        >
                                                            <button
                                                                type="button"
                                                                @click.prevent="
                                                                    $dispatch('open-modal', 'confirm-deletion');
                                                                    selectedDoctor = @js($doctor->user);
                                                                    selectedDoctorId = @js($doctor->id);
                                                                "
                                                                class="inline-flex items-center rounded-lg border border-transparent text-sm font-semibold text-red-600 hover:text-red-800 focus:text-red-800 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                                                            >
                                                                Ištrinti
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 p-3">
                                {{ $doctors->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
</x-app-layout>
