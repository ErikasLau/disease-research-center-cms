<x-app-layout>
    <x-slot name="header">
        {{ __("Tyrimo informacija") }}
    </x-slot>

    <x-view-block>
        @include("examination.partials.patient")
    </x-view-block>

    <x-view-block class="mt-4">
        @include("examination.partials.visit")
    </x-view-block>

    <x-view-block class="mt-4">
        @include("examination.partials.visit")
    </x-view-block>

    <x-view-block class="mt-4">
        @include("examination.partials.examination")
    </x-view-block>

    @if ($examination->result)
        <x-view-block class="mt-4">
            @include("examination.partials.result")
        </x-view-block>
        @if (! $examination->result->comment)
            <x-view-block class="mt-4">
                @include("examination.partials.create-comment")
            </x-view-block>
        @else
            <x-view-block class="mt-4">
                @include("examination.partials.comment")
            </x-view-block>
        @endif
    @endif
</x-app-layout>
