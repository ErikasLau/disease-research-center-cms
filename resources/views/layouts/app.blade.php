<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Laravel") }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
            rel="stylesheet"
        />

        <!-- Scripts -->
        @livewireStyles
        @vite("resources/css/app.css")
        @vite(["resources/js/app.js"])

        <script>
            localStorage.theme = 'light';
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include("layouts.navigation")

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        <h2
                            class="text-xl font-semibold leading-tight text-gray-800"
                        >
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
        <footer class="bg-white py-3 text-center">
            <p>
                Projektas:
                <strong>„Ligų tyrimų centras“</strong>
            </p>
            <p>
                Atliko:
                <strong>Erikas Laužadis</strong>
                , IFF-2/6
            </p>
        </footer>

        @livewireScriptConfig
    </body>
</html>
