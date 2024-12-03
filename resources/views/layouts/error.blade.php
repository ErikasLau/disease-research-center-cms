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
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="mt-6 min-h-screen w-full overflow-hidden">
            {{ $slot }}
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
    </body>
</html>
