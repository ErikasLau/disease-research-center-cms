<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Gydytojo komentaras
    </h2>
</div>
<div class="flex flex-col gap-1">
    <p>
        <span class="text-sm font-semibold text-gray-700">Pateiktas:</span>
        {{ date("Y-m-d H:i", strtotime($visit->examination->result->comment->created_at)) }}
    </p>
    <p>
        <span class="text-sm font-semibold text-gray-700">Komentaras:</span>
        {{ $visit->examination->result->comment->text }}
    </p>
</div>
