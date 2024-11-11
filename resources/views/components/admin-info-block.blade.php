@props(['href'])

@isset($href)
    <a href="{{$href}}">
        @endisset
        <div
            class="bg-gray-200 p-4 rounded h-36 flex flex-col items-center justify-center hover:bg-gray-300 duration-150">
            <h2 class="text-5xl font-bold">
                {{$count}}
            </h2>
            <p class="text-sm text-gray-500">
                {{$slot}}
            </p>
        </div>
        @isset($href)
    </a>
@endisset
