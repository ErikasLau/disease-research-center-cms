@props(['visit'])

<a href="/visit/{{$visit->id}}" {{ $attributes->merge(['class' => 'group bg-gray-100 hover:bg-gray-200 duration-100 rounded p-4']) }}>
    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-0">
            <span class="text-xl font-bold text-gray-900 leading-tight">{{$visit->doctor->user->name}}</span>
            <span class="text-sm font-light text-gray-600 leading-tight">{{$visit->doctor->specialization->name}}</span>
        </div>
        <div class="flex flex-col gap-0">
            <span
                class="text-md font-semibold text-gray-900 leading-tight">{{date('Y-m-d H:i', strtotime($visit->visit_date))}}</span>
            <span class="text-sm font-light text-gray-600 leading-tight">Vizito laikas</span>
        </div>
        <div class="flex flex-col gap-0">
            <span
                class="text-md font-semibold text-gray-900 leading-tight">{{__('page.visitStatus.' . $visit->status)}}</span>
            <span class="text-sm font-light text-gray-600 leading-tight">Statusas</span>
        </div>
    </div>
</a>