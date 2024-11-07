@php
    use App\Models\Doctor;use App\Models\Examination;use App\Models\Patient;use App\Models\Result;use App\Models\Role;use App\Models\User;use App\Models\Visit;use Illuminate\Support\Facades\DB;$patients_count = Patient::count();
    $doctors_count = Doctor::count();
    $laboratorians_count = User::where('role', Role::LABORATORIAN->name)->count();
    $admins_count = User::where('role', Role::ADMIN->name)->count();

    $visits_count = Visit::count();
    $examinations_count = Examination::count();
    $results_count = Result::count();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Valdymo skydas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        Patients count: {{$patients_count}}
                    </div>
                    <div>
                        Doctors count: {{$doctors_count}}
                    </div>
                    <div>
                        Laboratorians count: {{$laboratorians_count}}
                    </div>
                    <div>
                        Admins count: {{$admins_count}}
                    </div>
                    <div>
                        Visits count: {{$visits_count}}
                    </div>
                    <div>
                        Examinations count: {{$examinations_count}}
                    </div>
                    <div>
                        Results count: {{$results_count}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
