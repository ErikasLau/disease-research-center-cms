<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Tyrimo rezultatai
    </h2>
</div>
<div class="flex flex-col gap-1">
    <p>
        <span class="text-sm font-semibold text-gray-700">
            Rezultatai pateikti:
        </span>
        {{ date("Y-m-d H:i", strtotime($examination->created_at)) }}
    </p>
    <p>
        <span class="text-sm font-semibold text-gray-700">
            Rezultatus pateikęs laborantas:
        </span>
        {{ $examination->result->user->name }}
    </p>
    <p>
        <span class="text-sm font-semibold text-gray-700">
            Rezultatų išrašas:
        </span>
        {{ $examination->result->excerpt }}
    </p>
</div>
