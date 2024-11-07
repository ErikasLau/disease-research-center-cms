@php
    use App\Models\DoctorAppointmentSlot;use App\Models\Role;use App\Models\User;use App\Models\Visit;use App\Models\VisitStatus;use App\Models\WorkSchedule;use Illuminate\Database\Query\JoinClause;use Illuminate\Support\Facades\Auth;use App\Services\ScheduleService;use Illuminate\Support\Facades\DB;

    $completedVisits = Visit::with('doctor.user')->with('doctor.specialization')->orderBy('visit_date', 'desc')->take(4)->get();
    $createdVisits = Visit::with('doctor.user')->with('doctor.specialization')->where('status', VisitStatus::CREATED)->orderBy('visit_date', 'desc')->take(4)->get();

    function getNextTimeSlot(string $doctor_id){
        $appointment = DoctorAppointmentSlot::where('doctor_id', $doctor_id)->where('start_time', '>=', date('Y-m-d H:i', strtotime('now')))->where('is_available', false)->orderBy('start_time', 'ASC')->first();
        return $appointment ? $appointment->start_time : "Nėra galimų laikų";
    }

    $nextTime = DB::table('doctor_appointment_slots')
                ->select(DB::raw('MIN(start_time) as start_time'), 'doctor_id')
                ->where('doctor_appointment_slots.start_time', '>=', date('Y-m-d H:i', strtotime('now')))
                ->where('doctor_appointment_slots.is_available', false)
                ->groupBy('doctor_appointment_slots.doctor_id');

    $users = DB::table('users')
        ->where('role', Role::DOCTOR->name)
        ->select('users.name', 'doctor_specializations.name as specialization_name', 'next_time.start_time', 'doctors.id as doctor_id')
        ->join('doctors', function (JoinClause $join) {
            $join->on('users.id', '=', 'doctors.user_id');
        })
        ->join('doctor_specializations', function (JoinClause $join) {
            $join->on('doctors.doctor_specialization_id', '=', 'doctor_specializations.id');
        })
        ->rightJoinSub($nextTime, 'next_time', function (JoinClause $join) {
            $join->on('doctor_id', '=', 'doctors.id');
        })
        ->orderBy('next_time.start_time', 'ASC')
        ->take(8)
        ->get()
@endphp
<x-app-layout xmlns="http://www.w3.org/1999/html">
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
                        @if($completedVisits)
                            <div
                                class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                                @foreach($completedVisits as $visit)
                                    <x-visit-info-block :visit="$visit"/>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center my-8">
                                Būsimų vizitų nėra
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Praėję vizitai</h2>
                        </div>
                        @if($completedVisits)
                            <div
                                class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                                @foreach($completedVisits as $visit)
                                    <x-visit-info-block :visit="$visit"/>
                                @endforeach
                            </div>
                            <div class="text-right mt-3">
                                <a href="/patient/treatment-history/visits">
                                    <x-primary-button>
                                        Visi vizitai
                                    </x-primary-button>
                                </a>
                            </div>
                        @else
                            <div class="text-center my-8">
                                Praėjusių vizitų nėra
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if($users)
        <div class="max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Registracija pas
                                gydytojus</h2>
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
                                                    {{$user->specialization_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ date('Y-m-d H:i', strtotime($user->start_time))}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-start text-sm font-medium">
                                                    <a
                                                        href="/doctor/{{$user->doctor_id}}/visit"
                                                        class="inline-flex items-center text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                                    >
                                                        Peržiūrėti laikus
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right mt-3">
                                    <a href="/doctors">
                                        <x-primary-button>
                                            Visi gydytojai
                                        </x-primary-button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
