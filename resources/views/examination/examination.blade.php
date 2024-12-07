<x-app-layout>
    <x-slot name="header">
        {{ __("Valdymo skydas") }}
    </x-slot>

    <x-view-block>
        @include("examination.partials.patient")
    </x-view-block>

    <x-view-block class="mt-4">
        @include("examination.partials.visit")
    </x-view-block>

    <x-view-block class="mt-4">
        @include("examination.partials.examination-labo")
    </x-view-block>

    @if ($examination->result)
        <x-view-block class="mt-4">
            @include("examination.partials.result")
        </x-view-block>
        @if ($examination->result->comment)
            <x-view-block class="mt-4">
                @include("examination.partials.comment")
            </x-view-block>
        @endif
    @elseif ($examination->status == \App\Models\ExaminationStatus::NOT_COMPLETED->name)
        <x-view-block class="mt-4">
            @include("examination.partials.create-result")
        </x-view-block>
    @endif
</x-app-layout>
