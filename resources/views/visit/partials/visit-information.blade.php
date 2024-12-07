@php
    use App\Models\Role;
    use App\Models\VisitStatus;
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="mb-4 border-b-2 border-gray-300 pb-2">
    <h2 class="text-xl font-semibold uppercase leading-7 text-gray-900">
        Vizito informacija
    </h2>
</div>
<div class="flex flex-col gap-1">
    <p>
        <span class="text-sm font-semibold text-gray-700">Vizito data:</span>
        {{ date("Y-m-d H:i", strtotime($visit->visit_date)) }}
    </p>
    <p>
        <span class="text-sm font-semibold text-gray-700">Gydytojas:</span>
        {{ $visit->doctor->user->name }}
    </p>
    <p>
        <span class="text-sm font-semibold text-gray-700">
            Gydytojo specialybė:
        </span>
        {{ $visit->doctor->specialization->name }}
    </p>
    <div>
        <div class="flex items-center gap-2">
            <p class="flex flex-row items-center gap-2">
                <span class="text-sm font-semibold text-gray-700">
                    Vizito statusas:
                </span>
            </p>
            @if ($visit->status == VisitStatus::CREATED->name && ! $visit->examination && Auth::user()->role == Role::PATIENT->name)
                <form
                    action="/visit/{{ $visit->id }}"
                    method="POST"
                    x-data="{ selected: @js($visit->status), defaultSelected: @js($visit->status) }"
                    class="flex items-center gap-2"
                >
                    @csrf
                    @method("PATCH")
                    <select
                        id="visit_status"
                        name="visit_status"
                        x-model="selected"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        @foreach ($visitStatusToChange as $status)
                            <option value="{{ $status }}">
                                {{ __("page.visitStatus." . $status) }}
                            </option>
                        @endforeach
                    </select>
                    <template x-if="selected != defaultSelected">
                        <x-primary-button>Atnaujinti</x-primary-button>
                    </template>
                </form>
            @elseif ($visit->status != VisitStatus::CANCELED->name && ! $visit->examination && Auth::user()->role == Role::DOCTOR->name)
                <form
                    action="/visit/{{ $visit->id }}"
                    method="POST"
                    x-data="{ selected: @js($visit->status), defaultSelected: @js($visit->status) }"
                    class="flex items-center gap-2"
                >
                    @csrf
                    @method("PATCH")
                    <select
                        id="visit_status"
                        name="visit_status"
                        x-model="selected"
                        class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        @foreach ($visitStatus as $status)
                            <option value="{{ $status }}">
                                {{ __("page.visitStatus." . $status) }}
                            </option>
                        @endforeach
                    </select>
                    <template x-if="selected != defaultSelected">
                        <x-primary-button type="submit">
                            Atnaujinti
                        </x-primary-button>
                    </template>
                </form>
            @else
                {{ __("page.visitStatus." . $visit->status) }}
            @endif
            <div></div>
        </div>
        <x-input-error :messages="$errors->get('visit_status')" class="mt-2" />
    </div>
</div>
