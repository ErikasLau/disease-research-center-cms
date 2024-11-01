@php
    use App\Models\DoctorSpecialization;use App\Models\WeekDays;
    $specializations = DoctorSpecialization::all();
    $weekDays = WeekDays::values();

    $date = new DateTime("now", new DateTimeZone('Europe/Vilnius'));
@endphp

<script>
    function generateRandomPassword(length, includeUppercase, includeLowercase, includeNumbers, includeSpecialChars) {
        const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
        const numberChars = '0123456789';
        const specialChars = '!@#$%^&*()-=_+[]{}|;:,.<>?/';

        let allChars = '';
        let password = '';

        if (includeUppercase) allChars += uppercaseChars;
        if (includeLowercase) allChars += lowercaseChars;
        if (includeNumbers) allChars += numberChars;
        if (includeSpecialChars) allChars += specialChars;

        const allCharsLength = allChars.length;

        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(window.crypto.getRandomValues(new Uint32Array(1))[0] / (0xFFFFFFFF + 1) * allCharsLength);
            password += allChars.charAt(randomIndex);
        }

        return password;
    }

    function parseTime(s) {
        var c = s.split(':');
        return parseInt(c[0]) * 60 + parseInt(c[1]);
    }

    var limit = parseTime("23:59");

    function getDiff(start_time, end_time) {
        var a = parseTime(start_time), b = parseTime(end_time);
        if (b < a) // means its the next day.
            return Math.ceil((limit - a + b) / 60);
        else if (b > a)
            return Math.ceil((b - a) / 60);
        else if (b - a == 0)
            return 24.0;
    }

    function getDiffDate(start_date, end_date) {
        const start = new Date(start_date);
        const end = new Date(end_date)

        if (start > end) {
            return undefined
        }

        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

        return diffDays;
    }
</script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gydytojo kūrimas
        </h2>
    </x-slot>

    <x-modal name="add_new_specialization" focusable>
        <form action="/specialization" method="post" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Sukurkite naują gydytojo specializaciją') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Naujoji gydytojo specializacija, pridėjus, atsiras sąraše specializacijų sukuriant gydytoją.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="new_specialization" value="{{ __('Nauja gydytojo specializacija') }}"/>

                <x-text-input
                    id="new_specialization"
                    name="new specialization"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Specializacija') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2"/>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button
                    x-on:click.prevent="$dispatch('close')"
                    class="rounded-md text-white bg-gray-400 px-3 py-2 text-sm font-semibold shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    type="button">
                    Atšaukti
                </button>
                <button
                    x-on:click.prevent="$dispatch('close')"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    type="button">
                    Pridėti naują specialybę
                </button>
            </div>
        </form>
    </x-modal>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form action="/doctor" method="POST">
                    @csrf

                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">

                            <h2 class="text-base font-semibold leading-7 text-gray-900">Gydytojo paskyros
                                informacija</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Sukurkite gydytojo paskyrą nurodę pagrindinę
                                informaciją.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <x-input-label for="name" value="{{ __('Vardas') }}"/>
                                    <x-text-input
                                        id="name"
                                        name="name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="{{ __('Vardas') }}"
                                    />
                                    <x-input-error :messages="$errors->doctorCreation->get('name')" class="mt-2"/>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="last_name" value="{{ __('Pavardė') }}"/>
                                    <x-text-input
                                        id="last_name"
                                        name="last name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="{{ __('Pavardė') }}"
                                    />
                                    <x-input-error :messages="$errors->doctorCreation->get('last_name')" class="mt-2"/>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="email" value="{{ __('Elektroninio pašto adresas') }}"/>
                                    <x-text-input
                                        id="email"
                                        name="email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        placeholder="{{ __('Elektroninio pašto adresas') }}"
                                    />
                                    <x-input-error :messages="$errors->doctorCreation->get('email')" class="mt-2"/>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="phone_number" value="{{ __('Telefono numeris') }}"/>
                                    <x-text-input
                                        id="phone_number"
                                        name="phone number"
                                        type="tel"
                                        class="mt-1 block w-full"
                                        placeholder="{{ __('Telefono numeris') }}"
                                    />
                                    <x-input-error :messages="$errors->doctorCreation->get('phone_number')"
                                                   class="mt-2"/>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="specialization" value="{{ __('Gydytojo specializacija') }}"/>
                                    <select id="specialization" name="specialization"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                        @foreach($specializations as $specialization)
                                            <option>{{$specialization->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->doctorCreation->get('specialization')"
                                                   class="mt-2"/>
                                    <button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'add_new_specialization')"
                                            type="button"
                                            class="mt-1 text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                        Pridėti naują specializaciją?
                                    </button>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="licence" value="{{ __('Gydytojo licencijos numeris') }}"/>
                                    <x-text-input
                                        id="licence"
                                        name="licence"
                                        type="text"
                                        class="mt-1 block w-full"
                                        placeholder="{{ __('Gydytojo licencijos numeris') }}"
                                    />
                                    <x-input-error :messages="$errors->doctorCreation->get('licence')" class="mt-2"/>
                                </div>

                                <div class="sm:col-span-3" x-data="{ show: false }">
                                    <x-input-label for="password" value="{{ __('Slaptažodis') }}"/>

                                    <div class="relative mt-1">
                                        <x-text-input
                                            id="password"
                                            name="password"
                                            x-bind:type="show ? 'text' : 'password'"
                                            autocomplete="off"
                                            class="ps-4 pe-10 w-full"
                                            placeholder="{{ __('Slaptažodis') }}"
                                        />
                                        <button type="button"
                                                @click="show = !show"
                                                class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600 dark:text-neutral-600 dark:focus:text-blue-500">
                                            <svg class="shrink-0 size-3.5" width="24" height="24" viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path :class="!show ? 'block' : 'hidden'"
                                                      d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                                                <path :class="!show ? 'block' : 'hidden'"
                                                      d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                                                <path :class="!show ? 'block' : 'hidden'"
                                                      d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                                                <line :class="!show ? 'block' : 'hidden'" x1="2" x2="22" y1="2"
                                                      y2="22"></line>
                                                <path :class="show ? 'block' : 'hidden'"
                                                      d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle :class="show ? 'block' : 'hidden'" cx="12" cy="12"
                                                        r="3"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->doctorCreation->get('password')" class="mt-2"/>
                                </div>

                                <div class="sm:col-span-3">
                                    <x-input-label for="repeated-password" value="{{ __('Pakartoti slaptažodį') }}"/>
                                    <x-text-input
                                        id="repeated-password"
                                        name="repeated password"
                                        type="password"
                                        autocomplete="off"
                                        class="mt-1 block w-full"
                                        placeholder="{{ __('Pakartoti slaptažodį') }}"
                                    />
                                    <x-input-error :messages="$errors->doctorCreation->get('repeated-password')"
                                                   class="mt-2"/>
                                </div>

                                <div class="col-span-full text-right">
                                    <button
                                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        onclick="{const password = generateRandomPassword(12, true, true, true, true); document.getElementById('password').value = password; document.getElementById('repeated-password').value = password;}"
                                        type="button">
                                        Generuoti slaptažodį
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-12"
                             x-data="{ timetables: [], shift_start_time: @js($date->format('H:i')), shift_end_time: @js(date('H:i', strtotime($date->format('H:i'). ' + 8 hour'))), job_start_date: @js($date->format('Y-m-d')), job_end_date: @js(date('Y-m-d', strtotime($date->format('Y-m-d'). ' + 1 days'))), week_days: [], possible_week_days_array: @js($weekDays) }">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Darbo laiko tvarkaraštis</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Sudarykite gydytojo darbo laiko tvarkaraštį
                                pasirinkdami darbo dienas, laiką bei laikotarpį.</p>

                            <div class="flex flex-col gap-2 mt-5" x-show="timetables.length > 0">
                                <input type="hidden" id="timetables" name="timetables"
                                       :value="JSON.stringify(timetables)">
                                <template x-for="(timetable, index) in timetables.sort(function timetableSort(a, b) {
                                  // Parse start dates and times, handling potential errors
                                  const startA = new Date(a.job_start_date);
                                  const startB = new Date(b.job_start_date);

                                  const timeA = parseTime(a.shift_start_time);
                                  const timeB = parseTime(b.shift_start_time);

                                  // Handle invalid dates and times
                                  if (isNaN(startA.getTime()) || isNaN(startB.getTime()) || isNaN(timeA) || isNaN(timeB)) {
                                    console.error('Invalid date or time format in timetables');
                                    return 0;
                                  }

                                  // Compare dates first
                                  if (startA < startB) {
                                    return -1;
                                  } else if (startA > startB) {
                                    return 1;
                                  }

                                  // If dates are equal, compare times
                                  return timeA - timeB;
                                })">
                                    <div
                                        class="grid grid-cols-1 md:grid-cols-4 gap-4 border-black rounded border-2 p-3 bg-gray-50">
                                        <div class="text-center flex flex-col justify-center">
                                            <p class="text-sm font-medium text-gray-700">Darbo laikas</p>
                                            <p class="text-lg font-bold text-gray-900">
                                                <span x-text="timetable.shift_start_time"></span> –
                                                <span x-text="timetable.shift_end_time"></span>
                                            </p>
                                        </div>
                                        <div class="text-center flex flex-col justify-center">
                                            <p class="text-sm font-medium text-gray-700">Darbo laikotarpis</p>
                                            <p class="text-lg font-bold text-gray-900">
                                                <span x-text="timetable.job_start_date"></span> –
                                                <span x-text="timetable.job_end_date"></span>
                                            </p>
                                        </div>
                                        <div class="text-center flex flex-col justify-center">
                                            <p class="text-sm font-medium text-gray-700">Darbo dienos</p>
                                            <div class="flex flex-wrap gap-2 justify-center">
                                                <template x-for="timetable_week_day in timetable.week_days.sort(function(a, b) {
                                                  return a - b;
                                                })">
                                                    <span
                                                        class="bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-xs font-semibold flex items-center justify-center w-[32px] h-[32px]"
                                                        x-text="possible_week_days_array.find(el => el.value == timetable_week_day).name.slice(0, 2)"></span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="text-center flex flex-col justify-center">
                                            <button type="button" @click="timetables.splice(index, 1)"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Pašalinti
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-5 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                                <div class="col-span-full grid sm:grid-cols-2 grid-cols-1 gap-x-6 gap-y-2 ">
                                    <div class="sm:col-span-1">
                                        <x-input-label for="shift_start_time" value="{{ __('Darbo laiko pradžia') }}"/>
                                        <x-text-input
                                            id="shift_start_time"
                                            name="shift start time"
                                            type="time"
                                            class="mt-1 block w-full"
                                            x-model="shift_start_time"
                                        />
                                        <x-input-error :messages="$errors->doctorCreation->get('shift_start_time')"
                                                       class="mt-2"/>
                                    </div>

                                    <div class="sm:col-span-1">
                                        <x-input-label for="shift_start_time" value="{{ __('Darbo laiko pabaiga') }}"/>
                                        <x-text-input
                                            id="shift_end_time"
                                            name="shift end time"
                                            type="time"
                                            class="mt-1 block w-full"
                                            x-model="shift_end_time"
                                        />
                                        <x-input-error :messages="$errors->doctorCreation->get('shift_end_time')"
                                                       class="mt-2"/>
                                    </div>
                                    <div class="col-span-full font-light text-sm"
                                         x-show="shift_start_time && shift_end_time">
                                        <p>Numatytas darbo laikas (suapvalintas į didesnę pusę): <span class="font-bold"
                                                                                                       x-text="getDiff(shift_start_time, shift_end_time)"></span>
                                            valandos</p>
                                    </div>
                                </div>

                                <div class="col-span-full grid sm:grid-cols-2 grid-cols-1 gap-x-6 gap-y-2 ">
                                    <div class="sm:col-span-1">
                                        <x-input-label for="job_start_date" value="{{ __('Darbo pradžios data') }}"/>
                                        <x-text-input
                                            id="job_start_date"
                                            name="job start date"
                                            type="date"
                                            min="{{$date->format('Y-m-d')}}"
                                            x-model="job_start_date"
                                            class="mt-1 block w-full"
                                        />
                                        <x-input-error :messages="$errors->doctorCreation->get('job_start_date')"
                                                       class="mt-2"/>
                                    </div>

                                    <div class="sm:col-span-1">
                                        <x-input-label for="job_end_date" value="{{ __('Darbo pabaigos data') }}"/>
                                        <x-text-input
                                            id="job_end_date"
                                            name="job end date"
                                            type="date"
                                            min="{{$date->format('Y-m-d')}}"
                                            x-model="job_end_date"
                                            class="mt-1 block w-full"
                                        />
                                        <x-input-error :messages="$errors->doctorCreation->get('job_start_date')"
                                                       class="mt-2"/>
                                    </div>

                                    <div class="col-span-full font-light text-sm"
                                         x-show="job_start_date && job_end_date && new Date(job_start_date) < new Date(job_end_date)">
                                        <p>Numatytas galimas darbo laikotarpis: <span class="font-bold"
                                                                                      x-text="getDiffDate(job_start_date, job_end_date)"></span>
                                            dienos</p>
                                    </div>
                                </div>
                                <div class="col-span-full">
                                    <x-input-label for="week_days" value="{{ __('Darbo dienos') }}"/>
                                    <div id="week_days" class="flex gap-2 flex-wrap justify-around mt-2">
                                        @foreach($weekDays as $weekDay)
                                            <div
                                                class="flex items-center ps-4 border border-gray-200 bg-gray-50 hover:bg-gray-100 duration-150 rounded dark:border-gray-700 min-w-[160px]">
                                                <input id="bordered-radio-{{$weekDay['value']}}" type="checkbox"
                                                       value="{{$weekDay['value']}}" name="bordered-radio"
                                                       x-model="week_days"
                                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="bordered-radio-{{$weekDay['value']}}"
                                                       class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{$weekDay['name']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-span-full text-right">
                                    <button type="button" x-on:click="timetables.push({
                                            shift_start_time: shift_start_time,
                                            shift_end_time: shift_end_time,
                                            job_start_date: job_start_date,
                                            job_end_date: job_end_date,
                                            week_days: week_days
                                        })"
                                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                        Pridėti darbo tvarkaraštį
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="submit"
                                class="rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Sukurti gydytoją
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
