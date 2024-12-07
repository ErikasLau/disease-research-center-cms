<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Tyrimo paskyrimas
    </h2>
</div>
<form action="/examination/create" method="POST" class="flex flex-col gap-3">
    @csrf
    <input id="id" name="id" type="hidden" value="{{ $visit->id }}" />
    <div>
        <x-input-label
            for="examination_type"
            value="{{ __('Tyrimo tipas') }}"
        />
        <x-text-input
            id="examination_type"
            name="examination type"
            type="text"
            class="mt-1 block w-full"
            placeholder="{{ __('Tyrimo tipas') }}"
        />
        <x-input-error
            :messages="$errors->get('examination_type')"
            class="mt-2"
        />
    </div>
    <div>
        <x-input-label
            for="examination_comment"
            value="{{ __('Tyrimo komentaras') }}"
        />
        <x-textarea-input
            id="examination_comment"
            name="examination comment"
            type="text"
            class="mt-1 block w-full"
            placeholder="{{ __('Tyrimo komentaras') }}"
        />
        <x-input-error
            :messages="$errors->get('examination_comment')"
            class="mt-2"
        />
    </div>
    <div class="col-span-full text-right">
        <button
            type="submit"
            class="rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
            Paskirti tyrimą
        </button>
    </div>
</form>
