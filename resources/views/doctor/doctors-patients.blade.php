@php
    use App\Models\Role;use App\Models\User;use Illuminate\Database\Query\JoinClause;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\DB;
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
        ->leftJoinSub($nextTime, 'next_time', function (JoinClause $join) {
            $join->on('doctor_id', '=', 'doctors.id');
        })
        ->paginate(15);
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visi gydytojai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col">
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
                                                    {{$user->start_time ?? 'Galimo laiko nėra'}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-start text-sm font-medium">
                                                    <a

                                                        href="{{$user->start_time ? '/doctor/'. $user->doctor_id . '/visit' : '#'}}"
                                                        class="{{ $user->start_time ? 'text-blue-600 hover:text-blue-800 focus:text-blue-800' : 'text-gray-600 cursor-default' }} inline-flex items-center focus:outline-none text-sm font-semibold rounded-lg border border-transparent disabled:opacity-50 disabled:pointer-events-none"
                                                    >
                                                        Peržiūrėti laikus
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 p-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
