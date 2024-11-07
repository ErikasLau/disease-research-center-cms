@php
    use App\Models\Examination;use App\Models\ExaminationStatus;use App\Models\Role;use App\Models\User;use App\Models\Visit;use App\Models\VisitStatus;use Illuminate\Support\Facades\Auth;
    $users = User::where('role', Role::DOCTOR)->get()->except(Auth::id());

    $visits = Visit::orderBy('visit_date', 'desc')->take(8)->get();
    $examinations = Examination::where('status', ExaminationStatus::SENT_TO_CONFIRM->name)->orderBy('created_at', 'desc')->get()
@endphp

<x-app-layout xmlns="http://www.w3.org/1999/html">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Valdymo skydas') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto">
        <div class="max-w-7xl sm:px-6 lg:px-8 mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Artimiausi pacientų vizitai</h2>
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
                                                Pacientas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Statusas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Vizito laikas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Veiksmai
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                        @foreach ($visits as $visit)
                                            <tr class="hover:bg-gray-100">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ $visit->patient->user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ __('page.visitStatus.' . $visit->status) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{date('Y-m-d H:i', strtotime($visit->visit_date))}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-start text-sm font-medium">
                                                    <a type="button"
                                                       href="/visit/{{$visit->id}}"
                                                       class="inline-flex items-center text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                                    >
                                                        Peržiūrėti
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right mt-2">
                                    <a href="/visits">
                                        <x-primary-button>
                                            Visi vizitai
                                        </x-primary-button>
                                    </a>
                                </div>
                            </div>
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
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Pacientų tyrimai atsiųsti patvirtinti</h2>
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
                                                Pacientas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Statusas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Tyrimo tipas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Sukūrimo laikas
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                Veiksmai
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                        @foreach ($examinations as $examination)
                                            <tr class="hover:bg-gray-100">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ $examination->patient->user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ __('page.examinationStatus.' . $examination->status) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ $examination->type }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{$examination->created_at}}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-start text-sm font-medium">
                                                    <a type="button"
                                                       href="/examination/{{$examination->id}}"
                                                       class="inline-flex items-center text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                                    >
                                                        Peržiūrėti
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right mt-2">
                                    <a href="/examinations">
                                        <x-primary-button>
                                            Visi tyrimai
                                        </x-primary-button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
