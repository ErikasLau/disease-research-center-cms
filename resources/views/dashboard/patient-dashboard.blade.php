@php
    use App\Models\DoctorAppointmentSlot;use App\Models\Role;use App\Models\User;use App\Models\Visit;use App\Models\VisitStatus;use App\Models\WorkSchedule;use Illuminate\Support\Facades\Auth;use App\Services\ScheduleService;

    $users = User::where('role', Role::DOCTOR->name)->with('doctor.specialization')->get()->except(Auth::id());

    $completedVisits = Visit::with('doctor.user')->with('doctor.specialization')->orderBy('visit_date', 'desc')->take(4)->get();
    $createdVisits = Visit::with('doctor.user')->with('doctor.specialization')->where('status', VisitStatus::CREATED)->orderBy('visit_date', 'desc')->take(4)->get();

    function getNextTimeSlot(string $doctor_id){
        $appointment = DoctorAppointmentSlot::where('doctor_id', $doctor_id)->where('start_time', '>=', date('Y-m-d H:i', strtotime('now')))->where('is_available', false)->orderBy('start_time', 'ASC')->first();
        return $appointment ? $appointment->start_time : "Nėra galimų laikų";
    }
@endphp
<x-app-layout xmlns="http://www.w3.org/1999/html">
    <div id="modal-backdrop" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div id="modal" class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <h3>Pasirinkite norimą laiką vizitui</h3>
                            <p>
                                Kalendorius norimai datai pasirinkti
                            </p>
                            <p>

                            </p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button onclick="toggleModal()" type="button"
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                            Deactivate
                        </button>
                        <button onclick="toggleModal()" type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Valdymo skydas') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto">
        <div class="mb-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Būsimi vizitai</h2>
                        </div>
                        <div
                            class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                            @foreach($createdVisits as $visit)
                                <a href="/visit/{{$visit->id}}" class="group bg-gray-100 rounded p-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{$visit->doctor->user->name}}</h3>
                                    <p class="text-sm text-gray-600">{{$visit->doctor->specialization->name}}</p>
                                    <div class="flex flex-col">
                                        <span class="text-lg font-medium text-gray-900">{{$visit->visit_date}}</span>
                                        <span class="text-sm font-light text-gray-600">Vizito laikas</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Praėję vizitai</h2>
                        </div>
                        <div
                            class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                            @foreach($completedVisits as $visit)
                                <a href="/visit/{{$visit->id}}" class="group bg-gray-100 rounded p-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{$visit->doctor->user->name}}</h3>
                                    <p class="text-sm text-gray-600">{{$visit->doctor->specialization->name}}</p>
                                    <div class="flex flex-col">
                                        <span class="text-lg font-medium text-gray-900">{{$visit->visit_date}}</span>
                                        <span class="text-sm font-light text-gray-600">Vizito laikas</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Registracija pas
                                gydytojus</h2>
                        </div>
                        <div class="flex flex-col">

                        </div>
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                                <div class="overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Gydytojas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Specializacija
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Artimiausias laikas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Veiksmai
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                        @foreach ($users as $user)
                                            <tr class="hover:bg-gray-100">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{$user->doctor->specialization->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{getNextTimeSlot($user->doctor->id)}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-start text-sm font-medium">
                                                    <button type="button"
                                                            data-modal-id="{{$user->id}}"
                                                            class="inline-flex items-center text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                                            onclick="{updateVisit(this); toggleModal()}"
                                                    >
                                                        Peržiūrėti laikus
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
