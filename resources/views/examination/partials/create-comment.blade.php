<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Gydytojo rezultatų komentaras
    </h2>
</div>
<div class="px-8">
    <form action="/comment/create" method="POST">
        @csrf
        <input
            id="id"
            name="id"
            type="hidden"
            value="{{ $examination->result->id }}"
        />
        <x-input-label for="text" class="text-sm font-semibold text-gray-700">
            Komentaras
        </x-input-label>
        <x-textarea-input
            id="text"
            name="text"
            class="min-h-40 w-full"
            value="{{ old('text') }}"
            placeholder="Gydytojo komentaras apie tyrimo rezultatus"
        />
        <x-input-error :messages="$errors->get('text')" class="mt-2" />
        <div class="mt-3 text-right">
            <x-primary-button>Palikti komentarą</x-primary-button>
        </div>
    </form>
</div>
