<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proposal Tracker</title>
    <link rel="icon" href="{{ asset('assets/images/Icon.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts and Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-gray-50 text-gray-900 selection:bg-amber-500 selection:text-white">
    <div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">

        <!-- Background decorative elements -->
        <div class="absolute inset-0 z-0">
            <div
                class="absolute top-0 -left-4 w-72 h-72 bg-zinc-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob">
            </div>
            <div
                class="absolute top-0 -right-4 w-72 h-72 bg-amber-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="relative z-10 w-full max-w-5xl px-6 py-12 mx-auto text-center">

            <!-- Navbar / Login Links -->
            @if (Route::has('login'))
                <div class="absolute top-4 right-4 sm:top-8 sm:right-8 flex items-center gap-3 sm:gap-4 z-50">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-sm sm:text-base font-semibold text-gray-600 hover:text-amber-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-amber-500 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm sm:text-base font-semibold text-gray-600 hover:text-amber-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-amber-500 transition-colors">Log
                            in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-sm sm:text-base font-semibold text-gray-600 hover:text-amber-600 focus:outline focus:outline-2 focus:rounded-sm focus:outline-amber-500 transition-colors">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- Hero Section -->
            <div class="mb-12">
                <div class="flex justify-center mb-6">
                    <div
                        class="h-20 w-20 bg-gradient-to-tr from-amber-600 to-zinc-600 rounded-2xl shadow-xl flex items-center justify-center transform rotate-3 hover:rotate-6 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <h1
                    class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-amber-700 to-zinc-700 mb-4 px-2 sm:px-0">
                    JDH Edu Tracker
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto font-medium px-4 sm:px-0">
                    Platform pelacakan dan manajemen pengajuan proposal penelitian akademik modern.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full px-4 sm:px-0">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base font-bold text-white bg-amber-600 border border-transparent rounded-full shadow-lg hover:bg-amber-700 hover:shadow-amber-500/30 transition-all duration-300 hover:-translate-y-1">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base font-bold text-white bg-amber-600 border border-transparent rounded-full shadow-lg hover:bg-amber-700 hover:shadow-amber-500/30 transition-all duration-300 hover:-translate-y-1">
                        Log in to Platform
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base font-bold text-gray-700 bg-white border border-gray-200 rounded-full shadow hover:bg-gray-50 transition-all duration-300 hover:-translate-y-1">
                        Create Account
                    </a>
                @endauth
            </div>

            <!-- Features Grid -->
            <div class="mt-16 sm:mt-24 grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 px-4 sm:px-0">
                <!-- Feature 1 -->
                <div
                    class="bg-white/60 backdrop-blur-lg rounded-3xl p-6 sm:p-8 border border-white shadow-xl text-left hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Transparansi Penuh</h3>
                    <p class="text-gray-600">Lacak status proposal Anda secara real-time. Ketahui kapan dokumen Anda
                        dibaca dan dinilai oleh reviewer.</p>
                </div>
                <!-- Feature 2 -->
                <div
                    class="bg-white/60 backdrop-blur-lg rounded-3xl p-6 sm:p-8 border border-white shadow-xl text-left hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-12 h-12 bg-zinc-100 text-zinc-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Penilaian Terstruktur</h3>
                    <p class="text-gray-600">Reviewer dapat dengan mudah mengakses dokumen, memberi komentar spesifik,
                        dan menyetujui draft.</p>
                </div>
                <!-- Feature 3 -->
                <div
                    class="bg-white/60 backdrop-blur-lg rounded-3xl p-6 sm:p-8 border border-white shadow-xl text-left hover:-translate-y-2 transition-transform duration-300">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Penyimpanan Aman</h3>
                    <p class="text-gray-600">Proposal disimpan di server yang aman. Tidak ada lagi kekhawatiran dokumen
                        PDF hilang atau terselip.</p>
                </div>
            </div>

            <div class="mt-16 text-sm text-gray-500 font-medium">
                &copy; {{ date('Y') }} JDH Edu - Proposal Tracker. All rights reserved.
            </div>
        </div>
    </div>
</body>

</html>
