<button
    {{ $attributes->merge(["class" => "inline-flex items-center rounded-lg border border-transparent text-sm font-semibold text-red-600 hover:text-red-800 focus:text-red-800 focus:outline-none disabled:pointer-events-none disabled:opacity-50"]) }}
    type="button"
>
    {{ $slot }}
</button>
