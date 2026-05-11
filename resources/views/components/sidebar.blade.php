@php
$user = Auth::user();
$role = $user->role ?? 'mekanik';

$mekanikMenu = [
    ['name' => 'Dashboard', 'icon' => 'fa-home', 'route' => 'mekanik.dashboard'],
    ['name' => 'Input Activity', 'icon' => 'fa-edit', 'route' => 'mekanik.activities.index'],
    ['name' => 'Historical Replacement', 'icon' => 'fa-history', 'route' => 'mekanik.historical'],
    ['name' => 'APL Komponen Midlife', 'icon' => 'fa-file-excel', 'route' => 'mekanik.apl-files'],
    ['name' => 'Profile', 'icon' => 'fa-user', 'route' => 'mekanik.profile'],
];

$managementMenu = [
    ['name' => 'Dashboard', 'icon' => 'fa-home', 'route' => 'management.dashboard'],
    ['name' => 'Historical Replacement', 'icon' => 'fa-history', 'route' => 'management.historical'],
    ['name' => 'APL Komponen Midlife', 'icon' => 'fa-file-excel', 'route' => 'management.apl-files'],
    ['name' => 'Profile', 'icon' => 'fa-user', 'route' => 'management.profile'],
];

// Add Approval only for GL role
if ($role === 'gl') {
    array_splice($managementMenu, 1, 0, [['name' => 'Approval', 'icon' => 'fa-check-circle', 'route' => 'management.activities.index']]);
}

// Add User Management only for TERE role
if ($role === 'tere') {
    $managementMenu[] = ['name' => 'User Management', 'icon' => 'fa-users', 'route' => 'management.users.index'];
}

$menu = $role === 'mekanik' ? $mekanikMenu : $managementMenu;
@endphp

<aside class="w-64 bg-white shadow-lg flex flex-col fixed h-full z-50">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-kiss-scan.png') }}" alt="Logo KISS" class="w-10 h-10 object-contain">
            <div>
                <h1 class="font-bold text-xl text-maroon">KISS</h1>
                <p class="text-xs text-gray-400">Keep It Simple System</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-1">
            @foreach($menu as $item)
            <li>
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs($item['route']) ? 'bg-maroon text-white' : 'text-gray-600 hover:bg-pink-bg' }}">
                    <i class="fas {{ $item['icon'] }} w-5"></i>
                    <span class="font-medium">{{ $item['name'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </nav>

    <!-- User Profile -->
    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-maroon rounded-full flex items-center justify-center">
                <span class="text-white font-semibold">{{ substr($user->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-gray-800 text-sm truncate">{{ $user->name }}</p>
                <p class="text-xs text-gray-500">{{ ucfirst($role) }}</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full btn btn-ghost btn-sm text-error hover:bg-red-50">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </div>
</aside>