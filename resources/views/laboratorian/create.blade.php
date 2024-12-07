<x-app-layout>
    <x-slot name="header">
        {{ __("Laboranto kūrimas") }}
    </x-slot>

    <x-view-block>
        <form action="/laboratorian/create" method="POST">
            @csrf

            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900">
                        Laboranto paskyros informacija
                    </h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">
                        Sukurkite laboranto paskyrą nurodę pagrindinę
                        informaciją.
                    </p>

                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
                    >
                        <div class="sm:col-span-3">
                            <x-input-label
                                for="name"
                                value="{{ __('Vardas ir pavardė') }}"
                            />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full"
                                value="{{ old('name') }}"
                                placeholder="{{ __('Vardas ir pavardė') }}"
                            />
                            <x-input-error
                                :messages="$errors->get('name')"
                                class="mt-2"
                            />
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label
                                for="birth_date"
                                value="{{ __('Gimimo data') }}"
                            />
                            <x-text-input
                                id="birth_date"
                                name="birth date"
                                type="date"
                                class="mt-1 block w-full"
                                value="{{ old('birth_date') }}"
                                placeholder="{{ __('Gimimo data') }}"
                            />
                            <x-input-error
                                :messages="$errors->get('birth_date')"
                                class="mt-2"
                            />
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label
                                for="email"
                                value="{{ __('Elektroninio pašto adresas') }}"
                            />
                            <x-text-input
                                id="email"
                                name="email"
                                type="email"
                                class="mt-1 block w-full"
                                value="{{ old('email') }}"
                                placeholder="{{ __('Elektroninio pašto adresas') }}"
                            />
                            <x-input-error
                                :messages="$errors->get('email')"
                                class="mt-2"
                            />
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label
                                for="phone_number"
                                value="{{ __('Telefono numeris') }}"
                            />
                            <x-text-input
                                id="phone_number"
                                name="phone number"
                                type="tel"
                                class="mt-1 block w-full"
                                value="{{ old('phone_number') }}"
                                placeholder="{{ __('Telefono numeris') }}"
                            />
                            <x-input-error
                                :messages="$errors->get('phone_number')"
                                class="mt-2"
                            />
                        </div>

                        <div class="sm:col-span-3" x-data="{ show: false }">
                            <x-input-label
                                for="password"
                                value="{{ __('Slaptažodis') }}"
                            />

                            <div class="relative mt-1">
                                <x-text-input
                                    id="password"
                                    name="password"
                                    x-bind:type="show ? 'text' : 'password'"
                                    autocomplete="off"
                                    class="w-full pe-10 ps-4"
                                    placeholder="{{ __('Slaptažodis') }}"
                                />
                                <button
                                    type="button"
                                    @click="show = !show"
                                    class="absolute inset-y-0 end-0 z-20 flex cursor-pointer items-center rounded-e-md px-3 text-gray-400 focus:text-blue-600 focus:outline-none dark:text-neutral-600 dark:focus:text-blue-500"
                                >
                                    <svg
                                        class="size-3.5 shrink-0"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            :class="!show ? 'block' : 'hidden'"
                                            d="M9.88 9.88a3 3 0 1 0 4.24 4.24"
                                        ></path>
                                        <path
                                            :class="!show ? 'block' : 'hidden'"
                                            d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"
                                        ></path>
                                        <path
                                            :class="!show ? 'block' : 'hidden'"
                                            d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"
                                        ></path>
                                        <line
                                            :class="!show ? 'block' : 'hidden'"
                                            x1="2"
                                            x2="22"
                                            y1="2"
                                            y2="22"
                                        ></line>
                                        <path
                                            :class="show ? 'block' : 'hidden'"
                                            d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"
                                        ></path>
                                        <circle
                                            :class="show ? 'block' : 'hidden'"
                                            cx="12"
                                            cy="12"
                                            r="3"
                                        ></circle>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error
                                :messages="$errors->get('password')"
                                class="mt-2"
                            />
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label
                                for="password_confirmation"
                                value="{{ __('Pakartoti slaptažodį') }}"
                            />
                            <x-text-input
                                id="password_confirmation"
                                name="password confirmation"
                                type="password"
                                autocomplete="off"
                                class="mt-1 block w-full"
                                placeholder="{{ __('Pakartoti slaptažodį') }}"
                            />
                            <x-input-error
                                :messages="$errors->get('repeated-password')"
                                class="mt-2"
                            />
                        </div>

                        <div class="col-span-full text-right">
                            <x-create-button
                                onclick="{const password = generateRandomPassword(12, true, true, true, true); document.getElementById('password').value = password; document.getElementById('password_confirmation').value = password;}"
                                type="button"
                            >
                                Generuoti slaptažodį
                            </x-create-button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <x-primary-button type="submit">
                    Sukurti laborantą
                </x-primary-button>
            </div>
        </form>
    </x-view-block>
    <script>
        function generateRandomPassword(
            length,
            includeUppercase,
            includeLowercase,
            includeNumbers,
            includeSpecialChars,
        ) {
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
                const randomIndex = Math.floor(
                    (window.crypto.getRandomValues(new Uint32Array(1))[0] /
                        (0xffffffff + 1)) *
                        allCharsLength,
                );
                password += allChars.charAt(randomIndex);
            }

            return password;
        }
    </script>
</x-app-layout>
