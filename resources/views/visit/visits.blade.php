@php
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Visit;
    use Illuminate\Support\Facades\Auth;

    $doctor = Auth::user()->doctor;
    $visits = Visit::where("doctor_id", $doctor->id)
        ->orderBy("visit_date", "DESC")
        ->paginate(15);
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Vizitai") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (count($visits) > 0)
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
                                </div>
                            </div>
                            <div class="mt-3 p-3">
                                {{ $visits->links() }}
                            </div>
                        </div>
                    @else
                        <div class="my-8 text-center">
                            Vizitų istorija tuščia
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
