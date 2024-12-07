<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Tyrimo informacija
    </h2>
</div>
<p>
    <span class="text-sm font-semibold text-gray-700">Tyrimo tipas:</span>
    {{ $visit->examination->type }}
</p>
<p>
    <span class="text-sm font-semibold text-gray-700">Tyrimo statusas:</span>
    {{ __("page.examinationStatus." . $visit->examination->status) }}
</p>
<p>
    <span class="text-sm font-semibold text-gray-700">
        Gydytojo komentaras:
    </span>
    {{ $visit->examination->comment }}
</p>
<p>
    <span class="text-sm font-semibold text-gray-700">Tyrimas paskirtas:</span>
    {{ date("Y-m-d H:i", strtotime($visit->examination->created_at)) }}
</p>
<p>
    <span class="text-sm font-semibold text-gray-700">
        Tyrimas paskutinį kartą atnaujintas:
    </span>
    {{ date("Y-m-d H:i", strtotime($visit->examination->updated_at)) }}
</p>
