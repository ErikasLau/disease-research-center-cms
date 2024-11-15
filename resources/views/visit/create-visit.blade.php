@php
    use App\Models\Doctor;use App\Models\DoctorAppointmentSlot;
    $doctor = Doctor::where('id', $id)->first();
    $appointments = DoctorAppointmentSlot::where('doctor_id', $id)->with('doctor.specialization')->with('doctor.user')->where('start_time', '>=', date('Y-m-d H:i', strtotime('now')))->where('is_available', true)->orderBy('start_time', 'ASC')->get();

    $unique_dates = [];
    foreach ($appointments as $appointment) {
        $date_only = date('Y-m-d', strtotime($appointment->start_time));
        $unique_dates[$date_only] = $date_only;
    }
    $unique_dates = array_values($unique_dates);
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registracija pas gydytoją') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($doctor && count($appointments) > 0)
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">{{$doctor->user->name}}
                                , {{$doctor->specialization->name}}</h2>
                        </div>

                        @if($errors->any())
                            <div class="m-4 mx-6 p-6 bg-gray-100 rounded-md">
                            @foreach($errors->all() as $error)
                                <x-input-error :messages="$error" />
                            @endforeach
                            </div>
                        @endif

                        <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak
                             class="grid md:grid-cols-5 gap-4">
                            <div class="container mx-auto px-4 py-2 col-span-2">
                                <div class="bg-white rounded-lg shadow overflow-hidden">
                                    <div class="flex items-center justify-between py-2 px-6">
                                        <div>
                                        <span x-text="MONTH_NAMES[month]"
                                              class="text-lg font-bold text-gray-800"></span>
                                            <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                                        </div>
                                        <div class="border rounded-lg px-1" style="padding-top: 2px;">
                                            <button
                                                type="button"
                                                class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 items-center"
                                                :class="{'cursor-not-allowed opacity-25': month == 0 }"
                                                :disabled="month == 0 ? true : false"
                                                @click="month--; getNoOfDays()">
                                                <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </button>
                                            <div class="border-r inline-flex h-6"></div>
                                            <button
                                                type="button"
                                                class="leading-none rounded-lg transition ease-in-out duration-100 inline-flex items-center cursor-pointer hover:bg-gray-200 p-1"
                                                :class="{'cursor-not-allowed opacity-25': month == 11 }"
                                                :disabled="month == 11 ? true : false"
                                                @click="month++; getNoOfDays()">
                                                <svg class="h-6 w-6 text-gray-500 inline-flex leading-none" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="-mx-1 -mb-1">
                                        <div class="flex flex-wrap">
                                            <template x-for="(day, index) in DAYS" :key="index">
                                                <div style="width: 14.26%" class="px-2 py-2">
                                                    <div
                                                        x-text="day"
                                                        class="text-gray-600 text-sm uppercase tracking-wide font-bold text-center"></div>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex flex-wrap border-t border-l">
                                            <template x-for="blankday in blankdays">
                                                <div
                                                    style="width: 14.28%; height: 60px"
                                                    class="text-center border-r border-b px-4 pt-2"
                                                ></div>
                                            </template>
                                            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                                <div style="width: 14.28%; height: 60px"
                                                     class="px-4 pt-2 border-r border-b relative">
                                                    <div
                                                        @click="isAppointmentAvailable(date) ? selectAppointmentDay(date) : ''"
                                                        x-text="date"
                                                        class="inline-flex w-6 h-6 items-center justify-center text-center leading-none rounded-full transition ease-in-out duration-100"
                                                        :class="{'bg-blue-500 text-white cursor-pointer': isAppointmentAvailable(date) == true, 'text-gray-400': isEarlierThanToday(date) == true || isAppointmentAvailable(date) == false }"
                                                    ></div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-3">
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
                                                        Vizito laikas
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                                                        Veiksmai
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200">
                                                <template x-for="(appointment, index) in selectedDayAppointments"
                                                          :key="index">
                                                    <tr class="hover:bg-gray-100">
                                                        <td x-text="appointment.doctor.user.name"
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                        </td>
                                                        <td x-text="appointment.doctor.specialization.name"
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                        </td>
                                                        <td x-text="appointment.start_time"
                                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-start text-sm font-medium">
                                                            <button
                                                                @click="openModal(appointment.id, `${appointment.doctor.user.name}, ${appointment.doctor.specialization.name}, ${appointment.start_time}`)"
                                                                type="button"
                                                                x-data=""
                                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-visit')"
                                                                class="inline-flex items-center text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none">
                                                                Registruotis
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-modal name="confirm-visit" focusable>
                                <form method="post" action="/visit" class="p-6">
                                    @csrf

                                    <h2 class="text-lg font-medium text-gray-900">
                                        {{ __('Ar tikrai norite registruotis šiam vizitui?') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-700"><strong>Vizito informacija:</strong> <span
                                            x-text="register_information"></span></p>

                                    <input name="id" type="hidden" id="id" x-model="register_id"/>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button type="button" x-on:click="$dispatch('close')">
                                            {{ __('Atšaukti') }}
                                        </x-secondary-button>

                                        <x-primary-button type="submit" class="ms-3">
                                            {{ __('Patvirtinti') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </x-modal>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const MONTH_NAMES = ["Sausis",
            "Vasaris",
            "Kovas",
            "Balandis",
            "Gegužė",
            "Liepa",
            "Birželis",
            "Rugpjūtis",
            "Rugsėjis",
            "Spalis",
            "Lapkritis",
            "Gruodis"];
        const DAYS = ['Pi', 'An', 'Tr', 'Ke', 'Pe', 'Še', 'Se'];
        const APPOINTMENT_DAYS = @js($unique_dates);
        const APPOINTMENTS = @js($appointments);

        function app() {
            return {
                month: '',
                year: '',
                no_of_days: [],
                blankdays: [],
                days: ['Pi', 'An', 'Tr', 'Ke', 'Pe', 'Še', 'Se'],
                openEventModal: false,
                selectedDayAppointments: [],
                register_id: '',
                register_information: '',

                initDate() {
                    let today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();

                    //Set as selected
                    this.selectAppointmentDay(new Date(APPOINTMENT_DAYS[0]).getDate());
                },

                isToday(date) {
                    const today = new Date();
                    const d = new Date(this.year, this.month, date);

                    return today.toDateString() === d.toDateString() ? true : false;
                },

                isEarlierThanToday(date) {
                    const today = new Date();
                    return date < today.getDate()
                },

                isAppointmentAvailable(date) {
                    const d = new Date(this.year, this.month, date, 12);
                    return APPOINTMENT_DAYS.includes(d.toISOString().split('T')[0]);
                },

                filterAppointments(selectedDate) {
                    selectedDate = selectedDate.toISOString().split('T')[0];
                    return APPOINTMENTS.filter(appointment => {
                        const apptDate = new Date(appointment.start_time).toISOString().split('T')[0];
                        return apptDate === selectedDate;
                    });
                },

                selectAppointmentDay(date) {
                    this.selectedDayAppointments = this.filterAppointments(new Date(this.year, this.month, date, 12))
                    console.log(this.selectedDayAppointments)
                },

                openModal(id, text) {
                    this.register_id = id
                    this.register_information = text
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                    // find where to start calendar day of week
                    let dayOfWeek = new Date(this.year, this.month).getDay();
                    dayOfWeek = dayOfWeek === 0 ? 7 : dayOfWeek
                    console.log(dayOfWeek)
                    let blankdaysArray = [];
                    for (var i = 1; i < dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for (var i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                }
            }
        }
    </script>
</x-app-layout>
