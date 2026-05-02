@php
$roleLabels = [
    'mekanik' => 'Mekanik',
    'gl' => 'GL',
    'tere' => 'Tere',
    'planner' => 'Planner',
];
@endphp

<header class="bg-white shadow-sm sticky top-0 z-40 px-6 py-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">@yield('page_title', 'Dashboard')</h2>
            <p class="text-sm text-gray-500">@yield('page_subtitle', 'Welcome back')</p>
        </div>
        <div class="flex items-center gap-4">
            <button class="btn btn-ghost btn-circle relative">
                <i class="fas fa-bell text-gray-600"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
        </div>
    </div>
</header>