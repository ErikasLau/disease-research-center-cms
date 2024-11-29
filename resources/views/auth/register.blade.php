<x-guest-layout>
    <form method="POST" action="{{ route("register") }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Vardas')" />
            <x-text-input
                id="name"
                class="mt-1 block w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Elektroninis paštas')" />
            <x-text-input
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label
                for="phone_number"
                :value="__('Telefono numeris')"
            />
            <x-text-input
                id="phone_number"
                class="mt-1 block w-full"
                type="tel"
                name="phone_number"
                :value="old('phone_number')"
                required
                autocomplete="tel"
            />
            <x-input-error
                :messages="$errors->get('phone_number')"
                class="mt-2"
            />
        </div>

        <div class="mt-4">
            <x-input-label for="birth_date" :value="__('Gimimo data')" />
            <x-text-input
                id="birth_date"
                class="mt-1 block w-full"
                type="date"
                name="birth_date"
                :value="old('birth_date')"
                required
                autocomplete="birth-date"
            />
            <x-input-error
                :messages="$errors->get('phone_number')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Slaptažodis')" />

            <x-text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                :value="__('Patvirtinti slaptažodį')"
            />

            <x-text-input
                id="password_confirmation"
                class="mt-1 block w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <a
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                href="{{ route("login") }}"
            >
                {{ __("Jau esate užsiregistravęs?") }}
            </a>

            <x-primary-button class="ms-4">
                {{ __("Registruotis") }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
