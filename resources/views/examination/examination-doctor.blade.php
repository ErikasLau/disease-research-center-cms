@php
    use App\Models\ExaminationStatus;
    use App\Models\VisitStatus;
@endphp

@php
    $visitStatus = VisitStatus::values();
    $examinationStatus = ExaminationStatus::getOptions();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Tyrimo informacija") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 border-b-2 border-gray-300 pb-2">
                        <h2
                            class="text-xl font-semibold uppercase leading-7 text-gray-900"
                        >
                            Paciento informacija
                        </h2>
                    </div>

                    <div class="flex flex-col gap-1">
                        <p>
                            <strong>
                                {{ $examination->patient->user->name }}
                            </strong>
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Gimimo data:
                            </span>
                            {{ $examination->patient->user->birth_date }}
                            <span class="text-sm font-semibold text-gray-700">
                                ({{ (new DateTime("today"))->diff(new DateTime($examination->patient->user->birth_date))->y }}
                                metų amžiaus)
                            </span>
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                El. paštas:
                            </span>
                            {{ $examination->patient->user->email }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Telefono numeris:
                            </span>
                            {{ $examination->patient->user->phone_number }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 border-b-2 border-gray-300 pb-2">
                        <h2
                            class="text-xl font-semibold uppercase leading-7 text-gray-900"
                        >
                            Buvusio vizito informacija
                        </h2>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Vizito data:
                            </span>
                            {{ $examination->visit->visit_date }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Vizito sukūrimo data:
                            </span>
                            {{ $examination->visit->created_at }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Vizito atnaujinimo data:
                            </span>
                            {{ $examination->visit->updated_at }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Statusas:
                            </span>
                            {{ __("page.visitStatus." . $examination->visit->status) }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Gydytojo vardas ir pavardė:
                            </span>
                            {{ $examination->visit->doctor->user->name }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Gydytojo el. paštas:
                            </span>
                            {{ $examination->visit->doctor->user->email }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Gydytojo telefono numeris:
                            </span>
                            {{ $examination->visit->doctor->user->phone_number }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 border-b-2 border-gray-300 pb-2">
                        <h2
                            class="text-xl font-semibold uppercase leading-7 text-gray-900"
                        >
                            Tyrimo informacija
                        </h2>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Tyrimo tipas:
                            </span>
                            {{ $examination->type }}
                        </p>
                        <div class="flex items-center gap-2">
                            <p class="flex flex-row items-center gap-2">
                                <span
                                    class="text-sm font-semibold text-gray-700"
                                >
                                    Tyrimo statusas:
                                </span>
                                {{ __("page.examinationStatus." . $examination->status) }}
                            </p>
                        </div>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Tyrimo komentaras:
                            </span>
                            {{ $examination->comment }}
                        </p>
                    </div>
                </div>
            </div>
            @if ($examination->result)
                <div
                    class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="mb-4 border-b-2 border-gray-300 pb-2">
                            <h2
                                class="text-xl font-semibold uppercase leading-7 text-gray-900"
                            >
                                Tyrimo rezultatai
                            </h2>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p>
                                <span
                                    class="text-sm font-semibold text-gray-700"
                                >
                                    Rezultatai pateikti:
                                </span>
                                {{ date("Y-m-d H:i", strtotime($examination->created_at)) }}
                            </p>
                            <p>
                                <span
                                    class="text-sm font-semibold text-gray-700"
                                >
                                    Rezultatus pateikęs laborantas:
                                </span>
                                {{ $examination->result->user->name }}
                            </p>
                            <p>
                                <span
                                    class="text-sm font-semibold text-gray-700"
                                >
                                    Rezultatų išrašas:
                                </span>
                                {{ $examination->result->excerpt }}
                            </p>
                        </div>
                    </div>
                </div>
                @if (! $examination->result->comment)
                    <div
                        class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="mb-4 border-b-2 border-gray-300 pb-2">
                                <h2
                                    class="text-xl font-semibold uppercase leading-7 text-gray-900"
                                >
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
                                    <x-input-label
                                        for="text"
                                        class="text-sm font-semibold text-gray-700"
                                    >
                                        Komentaras
                                    </x-input-label>
                                    <x-textarea-input
                                        id="text"
                                        name="text"
                                        class="min-h-40 w-full"
                                        value="{{ old('text') }}"
                                        placeholder="Gydytojo komentaras apie tyrimo rezultatus"
                                    />
                                    <x-input-error
                                        :messages="$errors->get('text')"
                                        class="mt-2"
                                    />
                                    <div class="mt-3 text-right">
                                        <x-primary-button>
                                            Palikti komentarą
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div
                        class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div class="mb-4 border-b-2 border-gray-300 pb-2">
                                <h2
                                    class="text-xl font-semibold uppercase leading-7 text-gray-900"
                                >
                                    Gydytojo komentaras
                                </h2>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p>
                                    <span
                                        class="text-sm font-semibold text-gray-700"
                                    >
                                        Pateiktas:
                                    </span>
                                    {{ date("Y-m-d H:i", strtotime($examination->result->comment->created_at)) }}
                                </p>
                                <p>
                                    <span
                                        class="text-sm font-semibold text-gray-700"
                                    >
                                        Komentaras:
                                    </span>
                                    {{ $examination->result->comment->text }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
