<select wire:model="selectedSpecialization" id="specialization" name="specialization" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
    <option hidden value="">{{__("Pasirinkti specializaciją")}}</option>
    @foreach ($specializations as $specialization)
        <option value="{{ $specialization->id }}" {{ $selectedSpecialization == $specialization->id ? 'selected' : '' }}>{{ $specialization->name }}</option>
    @endforeach
</select>
