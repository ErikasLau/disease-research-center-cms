@php
    use App\Models\Role;
@endphp

<nav x-data="{ open: false }" class="border-b border-gray-100 bg-white">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route("dashboard") }}">
                        <x-application-logo
                            class="block h-9 w-auto fill-current text-gray-800"
                        />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                    >
                        {{ __("Valdymo skydas") }}
                    </x-nav-link>
                    @if (Auth::user()->role == Role::PATIENT->name)
                        <x-nav-link
                            :href="route('doctors')"
                            :active="request()->routeIs('doctors')"
                        >
                            {{ __("Visi gydytojai") }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('treatment-history')"
                            :active="request()->routeIs('treatment-history')"
                        >
                            {{ __("Gydimo istorija") }}
                        </x-nav-link>
                    @elseif (Auth::user()->role == Role::DOCTOR->name)
                        <x-nav-link
                            :href="route('visits')"
                            :active="request()->routeIs('visits')"
                        >
                            {{ __("Visi vizitai") }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('examinations')"
                            :active="request()->routeIs('examinations')"
                        >
                            {{ __("Visi tyrimai") }}
                        </x-nav-link>
                    @elseif (Auth::user()->role == Role::LABORATORIAN->name)
                        <x-nav-link
                            :href="route('examinations')"
                            :active="request()->routeIs('examinations')"
                        >
                            {{ __("Visi tyrimai") }}
                        </x-nav-link>
                    @elseif (Auth::user()->role == Role::ADMIN->name)
                        <x-nav-link
                            :href="route('patients')"
                            :active="request()->routeIs('patients')"
                        >
                            {{ __("Pacientai") }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('doctors')"
                            :active="request()->routeIs('doctors')"
                        >
                            {{ __("Gydytojai") }}
                        </x-nav-link>
                        <x-nav-link
                            :href="route('laboratorians')"
                            :active="request()->routeIs('laboratorians')"
                        >
                            {{ __("Laborantai") }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                        >
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg
                                    class="h-4 w-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link
                            :href="route('profile.edit')"
                            class="hover:bg-[#e7e7e7]"
                        >
                            {{ __("Paskyra") }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form
                            method="POST"
                            action="{{ route("logout") }}"
                            class="m-0"
                        >
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                class="border-t border-gray-200"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                            >
                                {{ __("Atsijungti") }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                >
                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            :class="{'hidden': open, 'inline-flex': ! open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{'hidden': ! open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
            >
                {{ __("Valdymo skydas") }}
            </x-responsive-nav-link>
            @if (Auth::user()->role == Role::PATIENT->name)
                <x-responsive-nav-link
                    :href="route('doctors')"
                    :active="request()->routeIs('doctors')"
                >
                    {{ __("Visi gydytojai") }}
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route('treatment-history')"
                    :active="request()->routeIs('treatment-history')"
                >
                    {{ __("Gydimo istorija") }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->role == Role::DOCTOR->name)
                <x-responsive-nav-link
                    :href="route('visits')"
                    :active="request()->routeIs('visits')"
                >
                    {{ __("Visi vizitai") }}
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route('examinations')"
                    :active="request()->routeIs('examinations')"
                >
                    {{ __("Visi tyrimai") }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->role == Role::LABORATORIAN->name)
                <x-responsive-nav-link
                    :href="route('examinations')"
                    :active="request()->routeIs('examinations')"
                >
                    {{ __("Visi tyrimai") }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->role == Role::ADMIN->name)
                <x-responsive-nav-link
                    :href="route('patients')"
                    :active="request()->routeIs('patients')"
                >
                    {{ __("Pacientai") }}
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route('doctors')"
                    :active="request()->routeIs('doctors')"
                >
                    {{ __("Gydytojai") }}
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route('laboratorians')"
                    :active="request()->routeIs('laboratorians')"
                >
                    {{ __("Laborantai") }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="border-t border-gray-200 pb-1 pt-4">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-sm font-medium text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __("Paskyra") }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route("logout") }}">
                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                    >
                        {{ __("Atsijungti") }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
