@php
    use App\Models\Doctor;
    use App\Models\Examination;
    use App\Models\Patient;
    use App\Models\Result;
    use App\Models\Role;
    use App\Models\User;
    use App\Models\Visit;
    use Illuminate\Support\Facades\DB;
    $patients_count = Patient::count();
    $doctors_count = Doctor::count();
    $laboratorians_count = User::where("role", Role::LABORATORIAN->name)->count();
    $admins_count = User::where("role", Role::ADMIN->name)->count();

    $visits_count = Visit::count();
    $examinations_count = Examination::count();
    $results_count = Result::count();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Valdymo skydas") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-4 gap-4">
                        <x-admin-info-block>
                            <x-slot name="count">
                                {{ $patients_count }}
                            </x-slot>
                            Pacientai
                        </x-admin-info-block>

                        <x-admin-info-block>
                            <x-slot name="count">
                                {{ $doctors_count }}
                            </x-slot>
                            Gydytojai
                        </x-admin-info-block>

                        <x-admin-info-block>
                            <x-slot name="count">
                                {{ $laboratorians_count }}
                            </x-slot>
                            Laborantai
                        </x-admin-info-block>

                        <x-admin-info-block>
                            <x-slot name="count">
                                {{ $admins_count }}
                            </x-slot>
                            Administratoriai
                        </x-admin-info-block>

                        <x-admin-info-block>
                            <x-slot name="count">
                                {{ $visits_count }}
                            </x-slot>
                            Vizitai
                        </x-admin-info-block>

                        <x-admin-info-block>
                            <x-slot name="count">
                                {{ $examinations_count }}
                            </x-slot>
                            Tyrimai
                        </x-admin-info-block>

                        <x-admin-info-block>
                            <x-slot name="count">
                                {{ $results_count }}
                            </x-slot>
                            Rezultatai
                        </x-admin-info-block>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
