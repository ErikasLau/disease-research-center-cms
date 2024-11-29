@php
    use App\Models\ExaminationStatus;
    use App\Models\Patient;
    use App\Models\VisitStatus;
@endphp

@php
    $visitStatus = VisitStatus::values();
    $examinationStatus = [ExaminationStatus::NOT_COMPLETED->name, ExaminationStatus::IN_PROGRESS->name];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Valdymo skydas") }}
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
                                    <template
                                        x-if="selected != defaultSelected"
                                    >
                                        <x-primary-button>
                                            Atnaujinti
                                        </x-primary-button>
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
                @if ($examination->result->comment)
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
            @elseif ($examination->status != ExaminationStatus::NOT_COMPLETED->name)
                <div
                    class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="mb-4 border-b-2 border-gray-300 pb-2">
                            <h2
                                class="text-xl font-semibold uppercase leading-7 text-gray-900"
                            >
                                Tyrimų rezultatai
                            </h2>
                            <p class="text-sm">
                                Atlikti tyrimo rezultatai, kurie bus siunčiami
                                tyrimą vizito metu paskyrusiam gydytojui.
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
                                <x-input-error
                                    :messages="$errors->all()"
                                    class="mt-2"
                                />
                                <div class="mt-3 text-right">
                                    <x-primary-button>
                                        Pateikti rezultatus
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
