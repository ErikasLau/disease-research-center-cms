<select
    wire:model="selectedSpecialization"
    id="specialization"
    name="specialization"
    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
>
    <option hidden value="">{{ __("Pasirinkti specializaciją") }}</option>
    @foreach ($specializations as $specialization)
        <option
            value="{{ $specialization->id }}"
            {{ $selectedSpecialization == $specialization->id ? "selected" : "" }}
        >
            {{ $specialization->name }}
        </option>
    @endforeach
</select>
