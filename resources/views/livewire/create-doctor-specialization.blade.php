<form
    wire:submit="save"
    x-on:specialization-added.window="$dispatch('close')"
    class="p-6"
>
    @csrf

    <h2 class="text-lg font-medium text-gray-900">
        {{ __("Sukurkite naują gydytojo specializaciją") }}
    </h2>

    <p class="mt-1 text-sm text-gray-600">
        {{ __("Naujoji gydytojo specializacija, pridėjus, atsiras sąraše specializacijų sukuriant gydytoją.") }}
    </p>

    <div class="mt-6">
        <x-input-label
            for="specialization_name"
            value="{{ __('Nauja gydytojo specializacija') }}"
        />

        <x-text-input
            wire:model="form.specialization_name"
            id="specialization_name"
            name="specialization_name"
            type="text"
            autocomplete="off"
            class="mt-1 block w-full"
            placeholder="{{ __('Specializacija') }}"
        />
        @error("form.specialization_name")
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>

    <div class="mt-6">
        <x-input-label
            for="specialization_description"
            value="{{ __('Specialization aprašymas') }}"
        />

        <x-textarea-input
            wire:model="form.specialization_description"
            id="specialization_description"
            name="specialization_description"
            type="text"
            autocomplete="off"
            class="mt-1 block w-full"
            placeholder="{{ __('Aprašymas') }}"
        />
        @error("form.specialization_description")
            <x-input-error :messages="$message" class="mt-2" />
        @enderror
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <button
            x-on:click.prevent="$dispatch('close')"
            class="rounded-md bg-gray-400 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            type="button"
        >
            Atšaukti
        </button>
        <button
            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            type="submit"
        >
            Pridėti naują specialybę
        </button>
    </div>
</form>
