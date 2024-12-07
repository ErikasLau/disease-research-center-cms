<x-app-layout>
    <x-slot name="header">
        {{ __("Registracija pas gydytoją") }}
    </x-slot>

    <x-view-block>
        @if ($doctor && count($appointments) > 0)
            <div class="mb-4 border-b-2 border-gray-300 pb-2">
                <h2
                    class="text-xl font-semibold uppercase leading-7 text-gray-900"
                >
                    {{ $doctor->user->name }} ,
                    {{ $doctor->specialization->name }}
                </h2>
            </div>

            @if ($errors->any())
                <div class="m-4 mx-6 rounded-md bg-gray-100 p-6">
                    @foreach ($errors->all() as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>
            @endif

            @include("visit.partials.calendar")
        @endif
    </x-view-block>
</x-app-layout>
