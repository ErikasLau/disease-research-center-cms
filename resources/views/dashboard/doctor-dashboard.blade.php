@php
    use App\Models\Examination;
    use App\Models\ExaminationStatus;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Visit;
    use App\Models\VisitStatus;
    use Illuminate\Support\Facades\Auth;

    $doctor = Auth::user()->doctor;

    $visits = Visit::orderBy("visit_date", "desc")
        ->where("doctor_id", $doctor->id)
        ->take(8)
        ->get();

    $examinations = Examination::where("status", ExaminationStatus::SENT_TO_CONFIRM->name)
        ->whereHas("visit", function ($query) use ($doctor) {
            $query->where("doctor_id", $doctor->id);
        })
        ->orderBy("created_at", "desc")
        ->take(8)
        ->get();
@endphp

<x-app-layout xmlns="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Valdymo skydas") }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-7xl py-12">
        <div class="mb-4 max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <div class="mb-4 border-b-2 border-gray-300 pb-2">
                            <h2
                                class="text-xl font-semibold uppercase leading-7 text-gray-900"
                            >
                                Artimiausi pacientų vizitai
                            </h2>
                        </div>
                        @if (count($visits) > 0)
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
                                                        Statusas
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Vizito laikas
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
                                                @foreach ($visits as $visit)
                                                    <tr
                                                        class="hover:bg-gray-100"
                                                    >
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800"
                                                        >
                                                            {{ $visit->patient->user->name }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ __("page.visitStatus." . $visit->status) }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ date("Y-m-d H:i", strtotime($visit->visit_date)) }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-start text-sm font-medium"
                                                        >
                                                            <a
                                                                type="button"
                                                                href="/visit/{{ $visit->id }}"
                                                                class="inline-flex items-center rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                                                            >
                                                                Peržiūrėti
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-2 text-right">
                                        <a href="/visits">
                                            <x-primary-button>
                                                Visi vizitai
                                            </x-primary-button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="my-8 text-center">
                                Artimiausių vizitų nėra
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <div class="mb-4 border-b-2 border-gray-300 pb-2">
                            <h2
                                class="text-xl font-semibold uppercase leading-7 text-gray-900"
                            >
                                Pacientų tyrimai atsiųsti patvirtinti
                            </h2>
                        </div>
                        @if (count($examinations) > 0)
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
                                                        Statusas
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Tyrimo tipas
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                                    >
                                                        Sukūrimo laikas
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
                                                @foreach ($examinations as $examination)
                                                    <tr
                                                        class="hover:bg-gray-100"
                                                    >
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800"
                                                        >
                                                            {{ $examination->patient->user->name }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ __("page.examinationStatus." . $examination->status) }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ $examination->type }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                                        >
                                                            {{ $examination->created_at }}
                                                        </td>
                                                        <td
                                                            class="whitespace-nowrap px-6 py-4 text-start text-sm font-medium"
                                                        >
                                                            <a
                                                                type="button"
                                                                href="/examination/{{ $examination->id }}"
                                                                class="inline-flex items-center rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                                                            >
                                                                Peržiūrėti
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-2 text-right">
                                        <a href="/examinations">
                                            <x-primary-button>
                                                Visi tyrimai
                                            </x-primary-button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="my-8 text-center">
                                Atsiųstų tyrimų nėra
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
