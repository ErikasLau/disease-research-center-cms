@php
    use App\Models\Role;
    use App\Models\VisitStatus;
    use Illuminate\Support\Facades\Auth;
    $visitStatus = VisitStatus::getOptions();
    $visitStatusToChange = [VisitStatus::CREATED->name, VisitStatus::CANCELED->name];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __("Vizitas") }}
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
                            Vizito informacija
                        </h2>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Vizito data:
                            </span>
                            {{ date("Y-m-d H:i", strtotime($visit->visit_date)) }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Gydytojas:
                            </span>
                            {{ $visit->doctor->user->name }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Gydytojo specialybė:
                            </span>
                            {{ $visit->doctor->specialization->name }}
                        </p>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="flex flex-row items-center gap-2">
                                    <span
                                        class="text-sm font-semibold text-gray-700"
                                    >
                                        Vizito statusas:
                                    </span>
                                </p>
                                @if ($visit->status == VisitStatus::CREATED->name && ! $visit->examination && Auth::user()->role == Role::PATIENT->name)
                                    <form
                                        action="/visit/{{ $visit->id }}"
                                        method="POST"
                                        x-data="{ selected: @js($visit->status), defaultSelected: @js($visit->status) }"
                                        class="flex items-center gap-2"
                                    >
                                        @csrf
                                        @method("PATCH")
                                        <select
                                            id="visit_status"
                                            name="visit_status"
                                            x-model="selected"
                                            class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                            @foreach ($visitStatusToChange as $status)
                                                <option value="{{ $status }}">
                                                    {{ __("page.visitStatus." . $status) }}
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
                                    </form>
                                @elseif ($visit->status != VisitStatus::CANCELED->name && ! $visit->examination && Auth::user()->role == Role::DOCTOR->name)
                                    <form
                                        action="/visit/{{ $visit->id }}"
                                        method="POST"
                                        x-data="{ selected: @js($visit->status), defaultSelected: @js($visit->status) }"
                                        class="flex items-center gap-2"
                                    >
                                        @csrf
                                        @method("PATCH")
                                        <select
                                            id="visit_status"
                                            name="visit_status"
                                            x-model="selected"
                                            class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                            @foreach ($visitStatus as $status)
                                                <option value="{{ $status }}">
                                                    {{ __("page.visitStatus." . $status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <template
                                            x-if="selected != defaultSelected"
                                        >
                                            <x-primary-button type="submit">
                                                Atnaujinti
                                            </x-primary-button>
                                        </template>
                                    </form>
                                @else
                                    {{ __("page.visitStatus." . $visit->status) }}
                                @endif
                                <div></div>
                            </div>
                            <x-input-error
                                :messages="$errors->get('visit_status')"
                                class="mt-2"
                            />
                        </div>
                    </div>
                </div>
            </div>

            @if (Auth::user()->role == Role::DOCTOR->name && ! $visit->examination && ! ($visit->status == VisitStatus::CANCELED->name || $visit->status == VisitStatus::NO_SHOW->name))
                <div
                    class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="mb-4 border-b-2 border-gray-300 pb-2">
                            <h2
                                class="text-xl font-semibold uppercase leading-7 text-gray-900"
                            >
                                Tyrimo paskyrimas
                            </h2>
                        </div>
                        <form
                            action="/examination/create"
                            method="POST"
                            class="flex flex-col gap-3"
                        >
                            @csrf
                            <input
                                id="id"
                                name="id"
                                type="hidden"
                                value="{{ $visit->id }}"
                            />
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
                    </div>
                </div>
            @endif

            @if ($visit->examination)
                <div
                    class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <div class="mb-4 border-b-2 border-gray-300 pb-2">
                            <h2
                                class="text-xl font-semibold uppercase leading-7 text-gray-900"
                            >
                                Tyrimo informacija
                            </h2>
                        </div>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Tyrimo tipas:
                            </span>
                            {{ $visit->examination->type }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Tyrimo statusas:
                            </span>
                            {{ __("page.examinationStatus." . $visit->examination->status) }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Gydytojo komentaras:
                            </span>
                            {{ $visit->examination->comment }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Tyrimas paskirtas:
                            </span>
                            {{ date("Y-m-d H:i", strtotime($visit->examination->created_at)) }}
                        </p>
                        <p>
                            <span class="text-sm font-semibold text-gray-700">
                                Tyrimas paskutinį kartą atnaujintas:
                            </span>
                            {{ date("Y-m-d H:i", strtotime($visit->examination->updated_at)) }}
                        </p>
                    </div>
                </div>

                @if ($visit->examination->result)
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
                                    {{ date("Y-m-d H:i", strtotime($visit->examination->created_at)) }}
                                </p>
                                <p>
                                    <span
                                        class="text-sm font-semibold text-gray-700"
                                    >
                                        Rezultatus pateikęs laborantas:
                                    </span>
                                    {{ $visit->examination->result->user->name }}
                                </p>
                                <p>
                                    <span
                                        class="text-sm font-semibold text-gray-700"
                                    >
                                        Rezultatų išrašas:
                                    </span>
                                    {{ $visit->examination->result->excerpt }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if ($visit->examination->result)
                        <div
                            class="mt-4 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                        >
                            <div class="p-6 text-gray-900">
                                <div
                                    class="mb-4 border-b-2 border-gray-300 pb-2"
                                >
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
                                        {{ date("Y-m-d H:i", strtotime($visit->examination->result->comment->created_at)) }}
                                    </p>
                                    <p>
                                        <span
                                            class="text-sm font-semibold text-gray-700"
                                        >
                                            Komentaras:
                                        </span>
                                        {{ $visit->examination->result->comment->text }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
