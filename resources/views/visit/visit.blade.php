@php
    use App\Models\Role;
    use App\Models\VisitStatus;
    use Illuminate\Support\Facades\Auth;
@endphp

<x-app-layout>
    <x-slot name="header">
        {{ __("Vizitas") }}
    </x-slot>

    <x-view-block>
        @include("visit.partials.visit-information")
    </x-view-block>

    @if (Auth::user()->role == Role::DOCTOR->name && ! $visit->examination && ! ($visit->status == VisitStatus::CANCELED->name || $visit->status == VisitStatus::NO_SHOW->name))
        <x-view-block class="mt-4">
            @include("visit.partials.examination-create")
        </x-view-block>
    @endif

    @if ($visit->examination)
        <x-view-block class="mt-4">
            @include("visit.partials.examination")
        </x-view-block>

        @if ($visit->examination->result)
            <x-view-block class="mt-4">
                @include("visit.partials.result")
            </x-view-block>

            @if ($visit->examination->result->comment)
                <x-view-block class="mt-4">
                    @include("visit.partials.comment")
                </x-view-block>
            @endif
        @endif
    @endif
</x-app-layout>
