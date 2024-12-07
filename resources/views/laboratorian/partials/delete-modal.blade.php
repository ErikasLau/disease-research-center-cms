<x-modal name="confirm-deletion" focusable>
    <form method="post" action="/laboratorian" class="p-6">
        @csrf
        @method("delete")

        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Ar tikrai norite pašalinti laborantą") }}
            <span
                class="font-semibold"
                x-text="selectedUser ? selectedUser.name : ''"
            ></span>
            ?
        </h2>

        <input id="id" name="id" x-model="selectedUserId" type="hidden" />

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Kai paskyra bus ištrinta, visi jos ištekliai ir duomenys bus ištrinti visam laikui. Įveskite slaptažodį, kad patvirtintumėte, jog norite visam laikui ištrinti paskyrą.") }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __("Atšaukti") }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __("Ištrinti") }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
