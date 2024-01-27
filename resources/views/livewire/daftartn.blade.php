<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'PSB TSN')</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Scripts -->
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
</head>

<body class="font-raleway antialiased bg-tsn-bg no-scrollbar">

    {{-- header --}}
    <div class="grid lg:grid-cols-3 sm:grid-cols-1 sticky top-0 h-fit z-50 bg-tsn-header border-b-4 border-tsn-accent">
        <div class="flex w-full lg:justify-self-start sm:justify-self-center px-1">
            <a href="http://127.0.0.1:8000/">
                <x-application-logo />
            </a>
        </div>
        <div></div>
        <div class="w-fit justify-self-end px-5 py-5">
            <figure><img src="\LogoTSN.png" alt="Album" class="w-16" /></figure>
        </div>

        <div class="col-span-3">
            <div class="relative justify-self-center">

                <div class="flex w-full justify-center">

                    <h3 class="pb-2 font-bold text-lg text-white text-center">Formulir PSB Qism Tarbiyatunnisaa</h3>

                </div>
            </div>
        </div>
    </div>

    @livewire('daftartn')


    <footer class="footer footer-center p-10 bg-tsn-header text-primary-content border-t-4 border-tsn-accent">
        <aside>
            <figure><img src="\LogoTSN.png" alt="Album" class="w-16" /></figure>
            <p class="font-raleway">
                Ma'had Ta'dzimussunnah <br />Sine Ngawi
            </p>
            <p class="font-raleway">Nomor Statistik Pesantren: 510035210133</p>
            <p class="font-raleway">Dusun Krajan RT 02/RW 02 Desa Ketanggung Kec. Sine Kab. Ngawi 63264</p>
            <p class="font-raleway text-center"><a href="https://maps.app.goo.gl/UP1YyR7V6J3tV3bH6">Link Google Maps</a>
            </p>
            <p class="font-raleway text-center"><a
                    href="https://maps.app.goo.gl/UP1YyR7V6J3tV3bH6">@svg('heroicon-o-map-pin', 'w-4 h-4', ['style'
                    => 'color: #d3c281'])</a></p>

        </aside>
    </footer>

    <footer class="footer footer-center bottom-0 bg-tsn-header text-primary-content">
        <p class="text-cente font-raleway">Copyright © 1445 H/2024 M - All right reserved</p>
    </footer>

    @filamentScripts
    @vite('resources/js/app.js')

</body>

</html>
