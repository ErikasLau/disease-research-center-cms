<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Tyrimų rezultatai
    </h2>
    <p class="text-sm">
        Atlikti tyrimo rezultatai, kurie bus siunčiami tyrimą vizito metu
        paskyrusiam gydytojui.
    </p>
</div>
<div class="px-8">
    <form action="/result/create" method="POST">
        @csrf
        <input
            id="id"
            name="id"
            type="hidden"
            value="{{ $examination->id }}"
        />
        <x-input-label
            for="excerpt"
            class="text-sm font-semibold text-gray-700"
        >
            Rezultatai
        </x-input-label>
        <x-textarea-input
            id="excerpt"
            name="excerpt"
            value="{{old('excerpt')}}"
            class="min-h-40 w-full"
            placeholder="Tyrimo rezultatai, kurie bus siunčiami gydytojui"
        />
        <x-input-error :messages="$errors->all()" class="mt-2" />
        <div class="mt-3 text-right">
            <x-primary-button>Pateikti rezultatus</x-primary-button>
        </div>
    </form>
</div>
