<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Ištrinti paskyrą') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Kai paskyra bus ištrinta, visi jos ištekliai ir duomenys bus ištrinti visam laikui. Prieš ištrindami paskyrą, atsisiųskite visus duomenis ar informaciją, kurią norite išsaugoti.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Ištrinti paskyrą') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Ar tikrai norite ištrinti savo paskyrą?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Kai paskyra bus ištrinta, visi jos ištekliai ir duomenys bus ištrinti visam laikui. Įveskite slaptažodį, kad patvirtintumėte, jog norite visam laikui ištrinti paskyrą.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Slaptažodis') }}" class="sr-only"/>

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Slaptažodis') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2"/>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Atšaukti') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Ištrinti paskyrą') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
