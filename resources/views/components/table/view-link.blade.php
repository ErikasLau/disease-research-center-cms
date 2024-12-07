<a
    type="button"
    {{ $attributes->merge(["class" => "inline-flex items-center rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 focus:outline-none disabled:pointer-events-none disabled:opacity-50"]) }}
>
    {{ $slot }}
</a>
