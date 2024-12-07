<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
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
        <span class="text-sm font-semibold text-gray-700">Gimimo data:</span>
        {{ $examination->patient->user->birth_date }}
        <span class="text-sm font-semibold text-gray-700">
            ({{ (new DateTime("today"))->diff(new DateTime($examination->patient->user->birth_date))->y }}
            metų amžiaus)
        </span>
    </p>
    <p>
        <span class="text-sm font-semibold text-gray-700">El. paštas:</span>
        {{ $examination->patient->user->email }}
    </p>
    <p>
        <span class="text-sm font-semibold text-gray-700">
            Telefono numeris:
        </span>
        {{ $examination->patient->user->phone_number }}
    </p>
</div>
