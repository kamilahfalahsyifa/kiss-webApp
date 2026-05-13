<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'KISS' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: '#8B0A50',
                        'maroon-dark': '#6B0840',
                        'pink-bg': '#FDF4F5',
                        'pink-soft': '#FCE4EC',
                    }
                }
            },
            daisyui: {
                themes: [{
                    mytheme: {
                        "primary": "#8B0A50",
                        "secondary": "#AD3F73",
                        "accent": "#F06292",
                        "neutral": "#1f2937",
                        "base-100": "#ffffff",
                        "base-200": "#FDF4F5",
                        "base-300": "#f3f4f6",
                        "info": "#06b6d4",
                        "success": "#10b981",
                        "warning": "#f59e0b",
                        "error": "#ef4444",
                    }
                }]
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
<style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-pink-bg" x-data="{ fileModalOpen: false, itemModalOpen: false, sidebarOpen: false }">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         @click="sidebarOpen = false"></div>

    <!-- Sidebar Component -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="flex-1 lg:ml-64 min-h-screen">
        <!-- Top Navbar -->
        <header class="bg-white shadow-sm sticky top-0 z-30 px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden btn btn-ghost btn-circle mr-2">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                    <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">@yield('page_subtitle', 'Welcome back')</p>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4 sm:p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>