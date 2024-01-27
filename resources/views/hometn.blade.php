<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-BZJHVHE7EZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-BZJHVHE7EZ');
</script>
    
    
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
    <div class="grid lg:grid-cols-3 sm:grid-cols-1 sticky top-0 h-64 z-50 bg-tsn-header border-b-4 border-tsn-accent">
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
                <div class=" bottom-0 flex w-full justify-center">
                    <p class="lg:text-5xl sm:text-xl text-white font-raleway"><strong>PENERIMAAN SANTRI
                            BARU</strong></p>
                </div>
                <div class="flex w-full justify-center">
                    <p class="lg:text-5xl sm:text-xl text-white font-raleway"><strong>MA'HAD
                            TA'DZIMUSSUNNAH</strong></p>
                </div>
                <div class="flex w-full justify-center">
                    <p class="lg:text-5xl sm:text-xl text-white font-raleway"><strong>SINE NGAWI</strong></p>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('message'))
    <div class="flex w-full justify-center bg-transparent py-4">
        <!-- The Modal -->
        <div id="myModal" class="modal-show bg-transparet w-full flex justify-center">
            <!-- Modal content -->
            <div
                class="bg-white w-fit p-2 flex flex-col rounded-xl shadow-xl border-2 border-tsn-header justify-center">
                <div class="flex justify-center">
                    <div class="flex">
                        @svg('heroicon-o-check-circle', 'w-10 h-10', ['style'
                        => 'color: #274043'])
                    </div>
                </div>
                <div class="flex">
                    <br>
                    <p class="text-center sm:text-xs lg:text-md">{{ session()->get('message') }}</p>
                    <br>
                </div>
                <div class="flex justify-center">
                    <a href="/tn/daftar" role="button" class="btn bg-tsn-accent focus:bg-tsn-bg">Tutup</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="w-full pt-8 justify-center">
        <p class="lg:text-3xl sm:text-xl text-tsn-header font-raleway text-center"><strong>WAKTU PENDAFTARAN</strong>
        </p>
        <p class="lg:text-3xl sm:text-xl text-tsn-header font-raleway text-center">01 Rajab 1445 H s/d 20 Sya'ban 1445 H
        </p>
        <p class="lg:text-3xl sm:text-xl text-tsn-header font-raleway text-center">13 Januari 2024 s/d 01 Maret 2024</p>
        <br>
        <p class="lg:text-base sm:text-base text-tsn-header font-raleway text-center">KBM dimulai Syawal 1445 H</p>
    </div>

    <div class="grid w-full h-fit justify-items-center p-4">

        {{-- TN --}}
        <div class="px-3 py-3 w-fit justify-center justify-self-center">
            <div class="card lg:card-side bg-base-100 shadow-xl px-4 py-4">
                <figure><img src="\logoqism\Tarbiyatunnisaa.png" alt="Album" class="w-32" /></figure>
                <div class="card-body">
                    <h2 class="card-title self-center text-center text-tsn-header">Pendaftaran</h2>
                    <h2 class="card-title self-center text-center text-tsn-header">Qism Tarbiyatunnisaa</h2>
                    <p class="self-center">Program untuk putri</p>
                    <br>
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr class="border-tsn-header">
                                <th class="text-tsn-header" colspan="2">Informasi hubungi:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- row 1 -->
                            <tr>
                                <th><a href="https://wa.me/62811366271">@svg('heroicon-o-phone', 'w-4 h-4', ['style'
                                        => 'color: #274043'])</a></th>
                                <td class="text-tsn-header"><a href="https://wa.me/62811366271">Kontak person</a></td>
                            </tr>

                        </tbody>
                    </table>
                    <br>
                    <div class="card-actions justify-start">

                            <a href="/tn/daftar" role="button" class="btn bg-tsn-accent focus:bg-tsn-bg">Daftar</a>
                        {{-- <dialog id="daftar_tn" class="modal">
                            <div class="modal-box">
                                <div class="sticky top-0 right-0">
                                    <form method="dialog">
                                        <button
                                            class="btn btn-sm btn-circle btn-ghost absolute right-0 top-0">✕</button>
                                    </form>
                                </div>
                                <div class="w-full">
                                    @livewire('daftartn')
                                </div>
                            </div>
                        </dialog> --}}

                    </div>

                </div>

            </div>
        </div>



    </div>

    <div class="flex w-full py-4 justify-center">

        @livewire('statuspendaftaran')

    </div>

   <div class="flex w-full py-4 justify-center">

        @livewire('mulaipendaftaran')

    </div>
    

    {{--
    <div class="w-auto h-auto p-4 shadow-xl">
        <div class="carousel rounded-xl w-full h-full shadow-xl">
            <div id="slide1" class="carousel-item relative w-full">
                <img src="tsngallery/Selatan menghadap utara.png" class="w-full" />
                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                    <a href="#slide4" class="btn btn-circle">❮</a>
                    <a href="#slide2" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide2" class="carousel-item relative w-full">
                <img src="https://daisyui.com/images/stock/photo-1609621838510-5ad474b7d25d.jpg" class="w-full" />
                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                    <a href="#slide1" class="btn btn-circle">❮</a>
                    <a href="#slide3" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide3" class="carousel-item relative w-full">
                <img src="https://daisyui.com/images/stock/photo-1414694762283-acccc27bca85.jpg" class="w-full" />
                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                    <a href="#slide2" class="btn btn-circle">❮</a>
                    <a href="#slide4" class="btn btn-circle">❯</a>
                </div>
            </div>
            <div id="slide4" class="carousel-item relative w-full">
                <img src="https://daisyui.com/images/stock/photo-1665553365602-b2fb8e5d1707.jpg" class="w-full" />
                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                    <a href="#slide3" class="btn btn-circle">❮</a>
                    <a href="#slide1" class="btn btn-circle">❯</a>
                </div>
            </div>
        </div>
    </div> --}}

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
