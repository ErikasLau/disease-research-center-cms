@php
    use App\Models\VisitStatus;use Illuminate\Support\Facades\Auth;
    $visitStatus = VisitStatus::getOptions();
    $visitStatusToChange = [VisitStatus::CREATED->name, VisitStatus::CANCELED->name]
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vizitas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="border-b-2 border-gray-300 pb-2 mb-4">
                        <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Vizito informacija</h2>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Vizito data:</span>
                            {{date('Y-m-d H:i', strtotime($visit->visit_date))}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Gydytojas:</span>
                            {{$visit->doctor->user->name}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Gydytojo specialybė:</span>
                            {{$visit->doctor->specialization->name}}
                        </p>
                        <div class="flex gap-2 items-center">
                            <p class="flex flex-row items-center gap-2">
                                <span class="text-gray-700 text-sm font-semibold">Vizito statusas:</span>
                            </p>
                            @if($visit->status == VisitStatus::CREATED->name)
                                <form x-data="{selected: @js($visit->status), defaultSelected: @js($visit->status)}"
                                      class="flex gap-2 items-center">
                                    <select id="visit_status" name="visit_status"
                                            x-model="selected"
                                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block">
                                        @foreach($visitStatusToChange as $status)
                                            <option

                                                value="{{$status}}">{{ __('page.visitStatus.' . $status) }}</option>
                                        @endforeach
                                    </select>
                                    <template x-if="selected != defaultSelected">
                                        <x-primary-button>
                                            Atnaujinti
                                        </x-primary-button>
                                    </template>
                                </form>
                            @else
                                {{__('page.visitStatus.' . $visit->status)}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->role == \App\Models\Role::DOCTOR->name && !$visit->examination && !($visit->status == VisitStatus::CANCELED->name || $visit->status == VisitStatus::NO_SHOW->name))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Tyrimo paskyrimas</h2>
                        </div>
                        <div class="flex flex-col gap-3">
                            <div>
                                <x-input-label for="examination_type" value="{{ __('Tyrimo tipas') }}"/>
                                <x-text-input
                                    id="examination_type"
                                    name="examination type"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="{{ __('Tyrimo tipas') }}"
                                />
                                <x-input-error :messages="$errors->examinationCreation->get('examination_type')"
                                               class="mt-2"/>
                            </div>
                            <div>
                                <x-input-label for="examination_comment" value="{{ __('Tyrimo komentaras') }}"/>
                                <x-textarea-input
                                    id="examination_comment"
                                    name="examination comment"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="{{ __('Tyrimo komentaras') }}"
                                />
                            </div>
                            <div class="col-span-full text-right">
                                <button type="submit"
                                        class="rounded-md bg-black px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                    Paskirti tyrimą
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($visit->examination)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Tyrimo informacija</h2>
                        </div>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Tyrimo tipas:</span>
                            {{$visit->examination->type}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Tyrimo statusas:</span>
                            {{ __('page.examinationStatus.' . $visit->examination->status) }}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Gydytojo komentaras:</span>
                            {{$visit->examination->comment}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Tyrimas paskirtas:</span>
                            {{date('Y-m-d H:i', strtotime($visit->examination->created_at))}}
                        </p>
                        <p>
                            <span
                                class="text-gray-700 text-sm font-semibold">Tyrimas paskutinį kartą atnaujintas:</span>
                            {{date('Y-m-d H:i', strtotime($visit->examination->updated_at))}}
                        </p>
                    </div>
                </div>

                @if($visit->examination->result)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                        <div class="p-6 text-gray-900">
                            <div class="border-b-2 border-gray-300 pb-2 mb-4">
                                <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Tyrimo
                                    rezultatai</h2>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p>
                                    <span class="text-gray-700 text-sm font-semibold">Rezultatai pateikti:</span>
                                    {{date('Y-m-d H:i', strtotime($visit->examination->created_at))}}
                                </p>
                                <p>
                                    <span
                                        class="text-gray-700 text-sm font-semibold">Rezultatus pateikęs laborantas:</span>
                                    {{ $visit->examination->result->user->name }}
                                </p>
                                <p>
                                    <span class="text-gray-700 text-sm font-semibold">Rezultatų išrašas:</span>
                                    {{ $visit->examination->result->excerpt }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($visit->examination->result)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                            <div class="p-6 text-gray-900">
                                <div class="border-b-2 border-gray-300 pb-2 mb-4">
                                    <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Gydytojo
                                        komentaras</h2>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p>
                                        <span class="text-gray-700 text-sm font-semibold">Pateiktas:</span>
                                        {{date('Y-m-d H:i', strtotime($visit->examination->result->comment->created_at))}}
                                    </p>
                                    <p>
                                    <span
                                        class="text-gray-700 text-sm font-semibold">Komentaras:</span>
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
