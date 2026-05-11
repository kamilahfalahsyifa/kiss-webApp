@extends('layouts.app')

@section('content')
<!-- NAVBAR -->
<nav class="navbar bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('images/logo-kiss-scan.png') }}" alt="Logo KISS" class="w-50 h-50 object-contain">                </div>
                <div>
                    <span class="font-bold text-lg text-maroon">KISS</span>
                    <p class="text-xs text-gray-500 -mt-1">Keep It Simple System</p>
                </div>
            </div>
        </div>

        <div class="hidden md:flex gap-8">
            <a href="#fitur" class="text-gray-600 hover:text-maroon font-medium transition">Fitur</a>
            <a href="#cara-kerja" class="text-gray-600 hover:text-maroon font-medium transition">Cara Kerja</a>
        </div>

        <div class="flex-none pl-10">
            <a href="{{ route('login') }}" class="btn bg-maroon text-white border-none hover:bg-maroon-dark">
                LOGIN
            </a>
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="bg-pink-bg min-h-[85vh] flex items-center">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl">
            <h1 class="text-6xl md:text-7xl font-extrabold text-maroon leading-tight mb-6">
                KISS
            </h1>
            <h2 class="text-2xl md:text-3xl font-semibold text-maroon/80 mb-6">
                Input & Record Historical Komponen
            </h2>
            <p class="text-gray-600 text-lg mb-4 leading-relaxed">
                Digitalisasi input data replacement komponen & record historical replacement komponen HD 785-7.
            </p>
            <p class="text-maroon font-bold text-xl mb-8 tracking-wider">
                CEPAT, TEPAT, AKURAT
            </p>
            <a href="{{ route('login') }}" class="btn bg-maroon text-white border-none hover:bg-maroon-dark px-10 py-3 text-lg">
                Mulai Sekarang
            </a>
        </div>
    </div>
</section>

<!-- FITUR SECTION -->
<section id="fitur" class="bg-pink-soft py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-maroon mb-4">Fitur Kiss</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Semua yang Anda butuhkan untuk input, record, historical penggantian komponen HD 785-7.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Card 1 -->
            <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-maroon/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-edit text-maroon text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Input Data Penggantian</h3>
                <p class="text-gray-600 leading-relaxed">
                    Input detail penggantian komponen dengan mudah termasuk tanggal penggantian dan hour meter actual
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-maroon/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-history text-maroon text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Historical Data Penggantian</h3>
                <p class="text-gray-600 leading-relaxed">
                    Arsip data detail report historical penggantian komponen tercatat dan dapat diakses dengan mudah
                </p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-lg transition">
                <div class="w-16 h-16 bg-maroon/10 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-cogs text-maroon text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">APL Komponen Midlife</h3>
                <p class="text-gray-600 leading-relaxed">
                    Data spare part yang diperlukan saat proses penggantian komponen midlife
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CARA KERJA SECTION -->
<section id="cara-kerja" class="bg-pink-bg py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-maroon mb-4">Cara Kerja Kiss</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Proses sederhana dan efisien untuk record historical komponen dan manajemen data.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Step 2 -->
            <div class="relative">
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 bg-maroon text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6">
                        1
                    </div>
                    <div class="hidden md:block absolute top-7 left-1/2 w-full h-0.5 bg-maroon/20"></div>
                    <div class="bg-white rounded-xl shadow-md p-6 text-center w-full">
                        <div class="w-12 h-12 bg-maroon/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-edit text-maroon text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Input Detail</h3>
                        <p class="text-gray-600 text-sm">Masukan detail penggantian komponen</p>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="relative">
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 bg-maroon text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6">
                        2
                    </div>
                    <div class="hidden md:block absolute top-7 left-1/2 w-full h-0.5 bg-maroon/20"></div>
                    <div class="bg-white rounded-xl shadow-md p-6 text-center w-full">
                        <div class="w-12 h-12 bg-maroon/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-save text-maroon text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Simpan Historical</h3>
                        <p class="text-gray-600 text-sm">Simpan data historical penggantian</p>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="relative">
                <div class="flex flex-col items-center">
                    <div class="w-14 h-14 bg-maroon text-white rounded-full flex items-center justify-center text-2xl font-bold mb-6">
                        3
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6 text-center w-full">
                        <div class="w-12 h-12 bg-maroon/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-maroon text-xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Cari Detail</h3>
                        <p class="text-gray-600 text-sm">Cari detail komponen dengan mudah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-maroon text-white py-8">
    <div class="container mx-auto px-4 text-center">
        <p class="font-medium">KISS</p>
        <p class="text-sm text-white/70 mt-1">Keep It Simple System</p>
        <p class="text-xs text-white/50 mt-4">&copy; {{ date('Y') }} KISS. All rights reserved.</p>
    </div>
</footer>
@endsection