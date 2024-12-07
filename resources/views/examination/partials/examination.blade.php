<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Tyrimo informacija
    </h2>
</div>
<div class="flex flex-col gap-1">
    <p>
        <span class="text-sm font-semibold text-gray-700">Tyrimo tipas:</span>
        {{ $examination->type }}
    </p>
    <div class="flex items-center gap-2">
        <p class="flex flex-row items-center gap-2">
            <span class="text-sm font-semibold text-gray-700">
                Tyrimo statusas:
            </span>
            {{ __("page.examinationStatus." . $examination->status) }}
        </p>
    </div>
    <p>
        <span class="text-sm font-semibold text-gray-700">
            Tyrimo komentaras:
        </span>
        {{ $examination->comment }}
    </p>
</div>
