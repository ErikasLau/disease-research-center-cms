@props([
    "examination",
])

<a
    href="/visit/{{ $examination->visit->id }}"
    class="group rounded bg-gray-100 p-4"
>
    <div class="flex flex-col">
        <span class="text-lg font-medium text-gray-900">
            {{ $examination->visit->doctor->user->name }}
        </span>
        <span class="text-sm font-light text-gray-600">Gydytojas</span>
    </div>
    <div class="flex flex-col">
        <span class="text-lg font-medium text-gray-900">
            {{ $examination->type }}
        </span>
        <span class="text-sm font-light text-gray-600">Tyrimo tipas</span>
    </div>
    <div class="flex flex-col">
        <span class="text-lg font-medium text-gray-900">
            {{ __("page.examinationStatus." . $examination->status) }}
        </span>
        <span class="text-sm font-light text-gray-600">Tyrimo statusas</span>
    </div>
</a>
