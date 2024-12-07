@php
    use App\Models\ExaminationStatus;
@endphp

<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Tyrimo informacija
    </h2>
</div>
<div class="flex flex-col gap-1">
    <p>
        <span class="text-sm font-semibold text-gray-700">Tyrimo tipas:</span>
        {{ $examination->type }}
    </p>
    <div class="flex items-center gap-2">
        <p class="flex flex-row items-center gap-2">
            <span class="text-sm font-semibold text-gray-700">
                Tyrimo statusas:
            </span>
            @if ($examination->status != ExaminationStatus::IN_PROGRESS->name)
                {{ __("page.examinationStatus." . $examination->status) }}
            @endif
        </p>
        @if ($examination->status == ExaminationStatus::IN_PROGRESS->name)
            <form
                action="/examination/{{ $examination->id }}"
                method="POST"
                x-data="{ selected: @js($examination->status), defaultSelected: @js($examination->status) }"
                class="flex items-center gap-2"
            >
                @csrf
                @method("PATCH")
                <select
                    id="status"
                    name="status"
                    class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    x-model="selected"
                >
                    @foreach ($examinationStatus as $status)
                        <option
                            value="{{ $status }}"
                            {{ $status === $examination->status ? "selected" : "" }}
                        >
                            {{ __("page.examinationStatus." . $status) }}
                        </option>
                    @endforeach
                </select>
                <template x-if="selected != defaultSelected">
                    <x-primary-button>Atnaujinti</x-primary-button>
                </template>
                <x-input-error
                    :messages="$errors->get('status')"
                    class="mt-2"
                />
            </form>
        @endif
    </div>
    <p>
        <span class="text-sm font-semibold text-gray-700">
            Tyrimo komentaras:
        </span>
        {{ $examination->comment }}
    </p>
</div>
