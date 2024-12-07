<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Buvusio vizito informacija
    </h2>
</div>
<div class="flex flex-col gap-1">
    <p>
        <span class="text-sm font-semibold text-gray-700">Vizito data:</span>
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
        <span class="text-sm font-semibold text-gray-700">Statusas:</span>
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
