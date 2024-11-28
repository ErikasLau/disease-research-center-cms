@php
    use App\Models\Patient;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    if (Auth::user()->patient) {
        $patients = Patient::where("id", "!=", Auth::user()->patient->id)->paginate(15);
    } else {
        $patients = Patient::paginate(15);
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Pacientai") }}
        </h2>
    </x-slot>

    <div x-data="{ selectedPatient: null, selectedPatientId: null }">
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <x-success-message />
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
                                                        Pacientas
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        El. paštas
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Tel. numeris
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
                                                @foreach ($patients as $patient)
                                                    <tr
                                                        class="hover:bg-gray-100"
                                                    >
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-800"
                                                        >
                                                            {{ $patient->user->name }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ $patient->user->email }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ $patient->user->phone_number }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ date("Y-m-d H:i", strtotime($patient->created_at)) }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-start text-sm font-medium"
                                                        >
                                                            <button
                                                                @click.prevent="
                                                                    $dispatch('open-modal', 'confirm-deletion');
                                                                    selectedPatient = @js($patient->user);
                                                                    selectedPatientId = @js($patient->id);
                                                                "
                                                                type="button"
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
                                {{ $patients->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-modal name="confirm-deletion" focusable>
            <form method="post" action="/patient" class="p-6">
                @csrf
                @method("delete")

                <h2 class="text-lg font-medium text-gray-900">
                    {{ __("Ar tikrai norite pašalinti vartotoją") }}
                    <span
                        class="font-semibold"
                        x-text="selectedPatient ? selectedPatient.name : ''"
                    ></span>
                    ?
                </h2>

                <input
                    id="id"
                    name="id"
                    x-model="selectedPatientId"
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
