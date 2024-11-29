@php
    use App\Models\DoctorAppointmentSlot;
    use App\Models\Examination;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Visit;
    use App\Models\VisitStatus;
    use App\Models\WorkSchedule;
    use Illuminate\Database\Query\JoinClause;
    use Illuminate\Support\Facades\Auth;
    use App\Services\ScheduleService;
    use Illuminate\Support\Facades\DB;

    $visits = Visit::where("patient_id", Auth::user()->patient->id)
        ->orderBy("visit_date", "DESC")
        ->take(8)
        ->get();
    $examinations = Examination::where("patient_id", Auth::user()->patient->id)
        ->take(8)
        ->get();
@endphp

<x-app-layout xmlns="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Gydymo istorija") }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl py-12">
        <div class="mb-4 sm:px-6 lg:px-8">
            @if (count($visits) > 0)
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <div class="mb-4 border-b-2 border-gray-300 pb-2">
                                <h2
                                    class="text-xl font-semibold uppercase leading-7 text-gray-900"
                                >
                                    Vizitai
                                </h2>
                            </div>
                            <div
                                class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
                            >
                                @foreach ($visits as $visit)
                                    <x-visit-info-block :visit="$visit" />
                                @endforeach
                            </div>
                            <div class="mt-2 text-right">
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

            @if (count($examinations) > 0)
                <div
                    class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <div class="mb-4 border-b-2 border-gray-300 pb-2">
                                <h2
                                    class="text-xl font-semibold uppercase leading-7 text-gray-900"
                                >
                                    Tyrimai
                                </h2>
                            </div>
                            <div
                                class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
                            >
                                @foreach ($examinations as $examination)
                                    <a
                                        href="/visit/{{ $examination->visit->id }}"
                                        class="group rounded bg-gray-100 p-4"
                                    >
                                        <div class="flex flex-col">
                                            <span
                                                class="text-lg font-medium text-gray-900"
                                            >
                                                {{ $examination->visit->doctor->user->name }}
                                            </span>
                                            <span
                                                class="text-sm font-light text-gray-600"
                                            >
                                                Gydytojas
                                            </span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-lg font-medium text-gray-900"
                                            >
                                                {{ $examination->type }}
                                            </span>
                                            <span
                                                class="text-sm font-light text-gray-600"
                                            >
                                                Tyrimo tipas
                                            </span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-lg font-medium text-gray-900"
                                            >
                                                {{ __("page.examinationStatus." . $examination->status) }}
                                            </span>
                                            <span
                                                class="text-sm font-light text-gray-600"
                                            >
                                                Tyrimo statusas
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="mt-2 text-right">
                                <a
                                    href="/patient/treatment-history/examinations"
                                >
                                    <x-primary-button>
                                        Visi tyrimai
                                    </x-primary-button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (! ($visits && $examinations))
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-900">
                        Jūsų gydymo istorija yra tuščia
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
