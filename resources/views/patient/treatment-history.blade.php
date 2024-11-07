@php
    use App\Models\DoctorAppointmentSlot;use App\Models\Examination;use App\Models\Role;use App\Models\User;use App\Models\Visit;use App\Models\VisitStatus;use App\Models\WorkSchedule;use Illuminate\Database\Query\JoinClause;use Illuminate\Support\Facades\Auth;use App\Services\ScheduleService;use Illuminate\Support\Facades\DB;

    $visits = Visit::with('doctor.user')->with('doctor.specialization')->orderBy('visit_date', 'desc')->take(8)->get();
    $examinations = Examination::take(8)->get();
@endphp
<x-app-layout xmlns="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gydymo istorija') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto">
        <div class="mb-4 sm:px-6 lg:px-8">
            @if($visits)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Vizitai</h2>
                        </div>
                        <div
                            class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                            @foreach($visits as $visit)
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
                        <div class="text-right mt-2">
                            <a href="/patient/treatment-history/visits">
                                <x-primary-button>
                                    Visi vizitai
                                </x-primary-button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($examinations)
            <div class="bg-white mt-4 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Tyrimai</h2>
                        </div>
                        <div
                            class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                            @foreach($examinations as $examination)
                                <a href="/visit/{{$examination->visit->id}}" class="group bg-gray-100 rounded p-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-lg font-medium text-gray-900">{{$examination->visit->doctor->user->name}}</span>
                                        <span class="text-sm font-light text-gray-600">Gydytojas</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-lg font-medium text-gray-900">{{$examination->type}}</span>
                                        <span class="text-sm font-light text-gray-600">Tyrimo tipas</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span
                                            class="text-lg font-medium text-gray-900">{{__('page.examinationStatus.' . $examination->status)}}</span>
                                        <span class="text-sm font-light text-gray-600">Tyrimo statusas</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="text-right mt-2">
                            <a href="/patient/treatment-history/examinations">
                                <x-primary-button>
                                    Visi tyrimai
                                </x-primary-button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!($visits && $examination))
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 text-center">
                            Jūsų gydymo istorija yra tuščia
                        </div>
                    </div>
            @endif
        </div>
    </div>
</x-app-layout>
