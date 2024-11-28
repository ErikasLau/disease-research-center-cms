@if (session()->has("success"))
    <div
        class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800"
        role="alert"
    >
        <span class="font-medium">Pavyko!</span>
        {{ session("success") }}
    </div>
@endif
