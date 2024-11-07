@php use App\Models\ExaminationStatus;use App\Models\VisitStatus; @endphp
@php
    $visitStatus = VisitStatus::values();
    $examinationStatus = ExaminationStatus::getOptions();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tyrimo informacija') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="border-b-2 border-gray-300 pb-2 mb-4">
                        <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Paciento informacija</h2>
                    </div>

                    <div class="flex flex-col gap-1">
                        <p>
                            <strong>{{$examination->patient->user->name}}</strong>
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Gimimo data:</span>
                            {{$examination->patient->user->birth_date}} <span
                                class="text-gray-700 text-sm font-semibold">({{(new DateTime('today'))->diff(new DateTime($examination->patient->user->birth_date))->y}} metų amžiaus)</span>
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">El. paštas:</span>
                            {{$examination->patient->user->email}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Telefono numeris:</span>
                            {{$examination->patient->user->phone_number}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <div class="border-b-2 border-gray-300 pb-2 mb-4">
                        <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Buvusio vizito
                            informacija</h2>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Vizito data:</span>
                            {{$examination->visit->visit_date}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Vizito sukūrimo data:</span>
                            {{$examination->visit->created_at}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Vizito atnaujinimo data:</span>
                            {{$examination->visit->updated_at}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Statusas:</span>
                            {{__('page.visitStatus.' . $examination->visit->status)}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Gydytojo vardas ir pavardė:</span>
                            {{$examination->visit->doctor->user->name}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Gydytojo el. paštas:</span>
                            {{$examination->visit->doctor->user->email}}
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Gydytojo telefono numeris:</span>
                            {{$examination->visit->doctor->user->phone_number}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <div class="border-b-2 border-gray-300 pb-2 mb-4">
                        <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Tyrimo informacija</h2>
                    </div>
                    <div class="flex flex-col gap-1">
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Tyrimo tipas:</span>
                            {{$examination->type}}
                        </p>
                        <p class="flex flex-row items-center gap-2">
                            <span class="text-gray-700 text-sm font-semibold">Tyrimo statusas:</span>
                            <select id="specialization" name="specialization"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block">
                                @foreach($examinationStatus as $status)
                                    <option
                                        value="{{$status}}" {{ $status === $examination->status ? 'selected' : '' }}>{{ __('page.examinationStatus.' . $status) }}</option>
                                @endforeach
                            </select>
                        </p>
                        <p>
                            <span class="text-gray-700 text-sm font-semibold">Tyrimo komentaras:</span>
                            {{$examination->comment}}
                        </p>
                    </div>
                </div>
            </div>
            @if($examination->result)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Tyrimo
                                rezultatai</h2>
                        </div>
                        <div class="flex flex-col gap-1">
                            <p>
                                <span class="text-gray-700 text-sm font-semibold">Rezultatai pateikti:</span>
                                {{date('Y-m-d H:i', strtotime($examination->created_at))}}
                            </p>
                            <p>
                                    <span
                                        class="text-gray-700 text-sm font-semibold">Rezultatus pateikęs laborantas:</span>
                                {{ $examination->result->user->name }}
                            </p>
                            <p>
                                <span class="text-gray-700 text-sm font-semibold">Rezultatų išrašas:</span>
                                {{ $examination->result->excerpt }}
                            </p>
                        </div>
                    </div>
                </div>
                @if(!$examination->result->comment)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                        <div class="p-6 text-gray-900">
                            <div class="border-b-2 border-gray-300 pb-2 mb-4">
                                <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Gydytojo rezultatų
                                    komentaras</h2>
                            </div>
                            <div class="px-8">
                                <form action="">
                                    <x-input-label for="results" class="text-gray-700 text-sm font-semibold">
                                        Komentaras
                                    </x-input-label>
                                    <x-textarea-input id="results" class="w-full min-h-40"
                                                      placeholder="Gydytojo komentaras apie tyrimo rezultatus"/>
                                    <div class="text-right mt-3">
                                        <x-primary-button>Palikti komentarą</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                        <div class="p-6 text-gray-900">
                            <div class="border-b-2 border-gray-300 pb-2 mb-4">
                                <h2 class="text-xl uppercase font-semibold leading-7 text-gray-900">Gydytojo
                                    komentaras</h2>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p>
                                    <span class="text-gray-700 text-sm font-semibold">Pateiktas:</span>
                                    {{date('Y-m-d H:i', strtotime($examination->result->comment->created_at))}}
                                </p>
                                <p>
                                    <span
                                        class="text-gray-700 text-sm font-semibold">Komentaras:</span>
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
