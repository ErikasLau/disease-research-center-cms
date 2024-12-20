<div
    x-data="app()"
    x-init="[initDate(), getNoOfDays()]"
    x-cloak
    class="grid grid-cols-1 gap-4 lg:grid-cols-5"
>
    <div class="container col-span-2 mx-auto px-4 py-2">
        <div
            class="overflow-hidden rounded-lg border-2 border-gray-300 bg-white"
        >
            <div class="flex items-center justify-between px-6 py-2">
                <div>
                    <span
                        x-text="MONTH_NAMES[month]"
                        class="text-lg font-bold text-gray-800"
                    ></span>
                    <span
                        x-text="year"
                        class="ml-1 text-lg font-normal text-gray-600"
                    ></span>
                </div>
                <div class="rounded-lg border px-1" style="padding-top: 2px">
                    <button
                        type="button"
                        class="inline-flex cursor-pointer items-center rounded-lg p-1 leading-none transition duration-100 ease-in-out hover:bg-gray-200"
                        :class="{'cursor-not-allowed opacity-25': nominal_month === 0 }"
                        :disabled="nominal_month === 0"
                        @click="prevMonth(); getNoOfDays()"
                    >
                        <svg
                            class="inline-flex h-6 w-6 leading-none text-gray-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                    </button>
                    <div class="inline-flex h-6 border-r"></div>
                    <button
                        type="button"
                        class="inline-flex cursor-pointer items-center rounded-lg p-1 leading-none transition duration-100 ease-in-out hover:bg-gray-200"
                        :class="{'cursor-not-allowed opacity-25': nominal_month === 2 }"
                        :disabled="nominal_month === 2"
                        @click="nextMonth(); getNoOfDays()"
                    >
                        <svg
                            class="inline-flex h-6 w-6 leading-none text-gray-500"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
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
                                class="text-center text-sm font-bold uppercase tracking-wide text-gray-600"
                            ></div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-wrap border-l border-t">
                    <template x-for="blankday in blankdays">
                        <div
                            style="width: 14.28%; height: 60px"
                            class="border-b border-r px-4 pt-2 text-center"
                        ></div>
                    </template>
                    <template
                        x-for="(date, dateIndex) in no_of_days"
                        :key="dateIndex"
                    >
                        <div
                            style="width: 14.28%; height: 60px"
                            class="flex items-center justify-center border-b border-r p-2"
                        >
                            <div
                                @click="isAppointmentAvailable(date) ? selectAppointmentDay(date) : ''"
                                x-text="date"
                                class="inline-flex h-[36px] w-[36px] items-center justify-center rounded-full text-center leading-none transition duration-100 ease-in-out"
                                :class="{'bg-blue-500 text-white cursor-pointer': isAppointmentAvailable(date) == true, 'text-gray-500': isEarlierThanToday(date) == true || isAppointmentAvailable(date) == false }"
                            ></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-3">
        <div class="-m-1.5 overflow-x-auto">
            <div class="inline-block min-w-full p-1.5 align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                >
                                    Gydytojas
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500"
                                >
                                    Specializacija
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
                        <tbody class="divide-y divide-gray-200">
                            <template
                                x-for="(appointment, index) in selectedDayAppointments"
                                :key="index"
                            >
                                <tr class="hover:bg-gray-100">
                                    <td
                                        x-text="appointment.doctor.user.name"
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800"
                                    ></td>
                                    <td
                                        x-text="appointment.doctor.specialization.name"
                                        class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                    ></td>
                                    <td
                                        x-text="appointment.start_time"
                                        class="whitespace-nowrap px-6 py-4 text-sm text-gray-800"
                                    ></td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-start text-sm font-medium"
                                    >
                                        <button
                                            @click="openModal(appointment.id, `${appointment.doctor.user.name}, ${appointment.doctor.specialization.name}, ${appointment.start_time}`)"
                                            type="button"
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-visit')"
                                            class="inline-flex items-center rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 focus:outline-none disabled:pointer-events-none disabled:opacity-50"
                                        >
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
                {{ __("Ar tikrai norite registruotis šiam vizitui?") }}
            </h2>

            <p class="mt-1 text-sm text-gray-700">
                <strong>Vizito informacija:</strong>
                <span x-text="register_information"></span>
            </p>

            <input name="id" type="hidden" id="id" x-model="register_id" />

            <div class="mt-6 flex justify-end">
                <x-secondary-button
                    type="button"
                    x-on:click="$dispatch('close')"
                >
                    {{ __("Atšaukti") }}
                </x-secondary-button>

                <x-primary-button type="submit" class="ms-3">
                    {{ __("Patvirtinti") }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
<script>
    const MONTH_NAMES = [
        'Sausis',
        'Vasaris',
        'Kovas',
        'Balandis',
        'Gegužė',
        'Liepa',
        'Birželis',
        'Rugpjūtis',
        'Rugsėjis',
        'Spalis',
        'Lapkritis',
        'Gruodis',
    ];
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
            nominal_month: 0,

            initDate() {
                let today = new Date();
                this.month = today.getMonth();
                this.year = today.getFullYear();
                this.datepickerValue = new Date(
                    this.year,
                    this.month,
                    today.getDate(),
                ).toDateString();

                //Set as selected
                this.selectAppointmentDay(
                    new Date(APPOINTMENT_DAYS[0]).getDate(),
                );
            },

            isEarlierThanToday(date) {
                const today = new Date();
                return date < today.getDate();
            },

            filterAppointmentsCache: {},

            filterAppointments(selectedDate) {
                const dateKey = selectedDate.toISOString().split('T')[0];

                if (!this.filterAppointmentsCache[dateKey]) {
                    this.filterAppointmentsCache[dateKey] = APPOINTMENTS.filter(
                        (appointment) => {
                            const apptDate = new Date(appointment.start_time)
                                .toISOString()
                                .split('T')[0];
                            return apptDate === dateKey;
                        },
                    );
                }

                return this.filterAppointmentsCache[dateKey];
            },

            isAppointmentAvailable(date) {
                const targetDate = new Date(this.year, this.month, date);
                return APPOINTMENT_DAYS.some(
                    (appointmentDate) =>
                        new Date(appointmentDate).toDateString() ===
                        targetDate.toDateString(),
                );
            },

            selectAppointmentDay(date) {
                const selectedDate = new Date(this.year, this.month, date, 12);
                this.selectedDayAppointments =
                    this.filterAppointments(selectedDate);
            },

            openModal(id, text) {
                this.register_id = id;
                this.register_information = text;
            },

            nextMonth() {
                this.nominal_month++;
                if (this.month === 11) {
                    this.year = this.year + 1;
                    this.month = 0;
                } else {
                    this.month++;
                }
            },

            prevMonth() {
                this.nominal_month--;
                if (this.month === 0) {
                    this.year = this.year - 1;
                    this.month = 11;
                } else {
                    this.month--;
                }
            },

            getNoOfDays() {
                let daysInMonth = new Date(
                    this.year,
                    this.month + 1,
                    0,
                ).getDate();

                // find where to start calendar day of week
                let dayOfWeek = new Date(this.year, this.month).getDay();
                dayOfWeek = dayOfWeek === 0 ? 7 : dayOfWeek;

                let blankdaysArray = [];
                for (let i = 1; i < dayOfWeek; i++) {
                    blankdaysArray.push(i);
                }

                let daysArray = [];
                for (let i = 1; i <= daysInMonth; i++) {
                    daysArray.push(i);
                }

                this.blankdays = blankdaysArray;
                this.no_of_days = daysArray;
            },
        };
    }
</script>
