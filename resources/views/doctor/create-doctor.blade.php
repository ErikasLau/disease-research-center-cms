@php
    use App\Models\DoctorSpecialization;
    $specializations = DoctorSpecialization::all();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gydytojo kūrimo forma
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form>
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Use a permanent address where you can
                                receive mail.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="name"
                                           class="block text-sm font-medium leading-6 text-gray-900">Vardas</label>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name"
                                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Pavardė</label>
                                    <div class="mt-2">
                                        <input type="text" name="last-name" id="last-name"
                                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Elektroninis
                                        paštas</label>
                                    <div class="mt-2">
                                        <input type="email" name="email" id="email"
                                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="number" class="block text-sm font-medium leading-6 text-gray-900">Telefono
                                        numeris</label>
                                    <div class="mt-2">
                                        <input type="text" name="number" id="number"
                                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="col-span-full">
                                    <label for="specialization"
                                           class="block text-sm font-medium leading-6 text-gray-900">Gydytojo
                                        specializacija</label>
                                    <div class="mt-2">
                                        <select id="specialization" name="specialization"
                                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @foreach($specializations as $specialization)
                                                <option>{{$specialization->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Slaptažodis</label>
                                    <div class="mt-2">
                                        <input type="password" name="password" id="password"
                                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="repeated-password"
                                           class="block text-sm font-medium leading-6 text-gray-900">Pakartoti
                                        slaptažodį</label>
                                    <div class="mt-2">
                                        <input type="password" name="repeated-password" id="repeated-password"
                                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Darbo laiko tvarkaraštis</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">We'll always let you know about important
                                changes, but you pick what else you want to hear about.</p>

                            <div class="mt-10 space-y-10">
                                <fieldset>
                                    <legend class="text-sm font-semibold leading-6 text-gray-900">By Email</legend>
                                    <div class="mt-6 space-y-6">
                                        <div class="relative flex gap-x-3">
                                            <div class="flex h-6 items-center">
                                                <input id="comments" name="comments" type="checkbox"
                                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            </div>
                                            <div class="text-sm leading-6">
                                                <label for="comments" class="font-medium text-gray-900">Comments</label>
                                                <p class="text-gray-500">Get notified when someones posts a comment on a
                                                    posting.</p>
                                            </div>
                                        </div>
                                        <div class="relative flex gap-x-3">
                                            <div class="flex h-6 items-center">
                                                <input id="candidates" name="candidates" type="checkbox"
                                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            </div>
                                            <div class="text-sm leading-6">
                                                <label for="candidates"
                                                       class="font-medium text-gray-900">Candidates</label>
                                                <p class="text-gray-500">Get notified when a candidate applies for a
                                                    job.</p>
                                            </div>
                                        </div>
                                        <div class="relative flex gap-x-3">
                                            <div class="flex h-6 items-center">
                                                <input id="offers" name="offers" type="checkbox"
                                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            </div>
                                            <div class="text-sm leading-6">
                                                <label for="offers" class="font-medium text-gray-900">Offers</label>
                                                <p class="text-gray-500">Get notified when a candidate accepts or
                                                    rejects an offer.</p>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend class="text-sm font-semibold leading-6 text-gray-900">Push Notifications
                                    </legend>
                                    <p class="mt-1 text-sm leading-6 text-gray-600">These are delivered via SMS to your
                                        mobile phone.</p>
                                    <div class="mt-6 space-y-6">
                                        <div class="flex items-center gap-x-3">
                                            <input id="push-everything" name="push-notifications" type="radio"
                                                   class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            <label for="push-everything"
                                                   class="block text-sm font-medium leading-6 text-gray-900">Everything</label>
                                        </div>
                                        <div class="flex items-center gap-x-3">
                                            <input id="push-email" name="push-notifications" type="radio"
                                                   class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            <label for="push-email"
                                                   class="block text-sm font-medium leading-6 text-gray-900">Same as
                                                email</label>
                                        </div>
                                        <div class="flex items-center gap-x-3">
                                            <input id="push-nothing" name="push-notifications" type="radio"
                                                   class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                            <label for="push-nothing"
                                                   class="block text-sm font-medium leading-6 text-gray-900">No push
                                                notifications</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                        <button type="submit"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
