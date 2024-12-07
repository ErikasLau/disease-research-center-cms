<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="inline-block min-w-full p-1.5 align-middle">
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            {{ $thead }}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{ $tbody }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @isset($pagination)
        <div class="mt-3 p-3">
            {{ $pagination }}
        </div>
    @endisset
</div>
