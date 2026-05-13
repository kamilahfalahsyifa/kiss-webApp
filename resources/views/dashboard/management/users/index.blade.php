@extends('layouts.dashboard')

@section('page_title', 'User Management')
@section('page_subtitle', 'Manage system users')

@section('content')
@if(session('success'))
<div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 flex items-center gap-3 shadow-sm">
    <i class="fas fa-check-circle text-green-600"></i>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800 flex items-center gap-3 shadow-sm">
    <i class="fas fa-exclamation-circle text-red-600"></i>
    <span class="text-sm font-medium">{{ session('error') }}</span>
</div>
@endif

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
    <div>
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">User Management</h2>
        <p class="text-gray-500 text-xs sm:text-sm mt-1">Manage all system users</p>
    </div>
    <a href="{{ route('management.users.create') }}"
       class="btn bg-maroon text-white hover:bg-maroon-dark px-4 sm:px-5 py-2.5 rounded-xl flex items-center justify-center gap-2 text-sm font-medium shadow-sm transition-all w-full sm:w-auto">
        <i class="fas fa-user-plus"></i>
        Add User
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto p-5">
        <table class="table w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Name</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Email</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Role</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Created At</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-gray-100 hover:bg-pink-bg/50 transition">
                    <td class="px-4 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $user->email }}</td>
                    <td class="px-4 py-4">
                        @if($user->role === 'mekanik')
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Mekanik</span>
                        @elseif($user->role === 'planner')
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">Planner</span>
                        @elseif($user->role === 'gl')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">GL</span>
                        @elseif($user->role === 'tere')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-medium">TERE</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-gray-600 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('management.users.edit', $user->id) }}"
                               class="btn btn-sm bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border-none px-3 py-1.5 rounded-lg" title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <button type="button"
                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                    class="btn btn-sm bg-red-100 text-red-700 hover:bg-red-200 border-none px-3 py-1.5 rounded-lg" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                        <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg font-medium">No users found</p>
                        <p class="text-sm">Add a new user to get started</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="p-5 border-t border-gray-200 bg-white">
        {{ $users->withQueryString()->links() }}
    </div>
    @endif
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 transform transition-all">
        <div class="text-center">
            <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete User</h3>
            <p class="text-gray-500 text-sm mb-6 leading-relaxed">Are you sure you want to delete <span id="deleteUserName" class="font-bold text-gray-800"></span>? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="btn btn-ghost flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl py-2.5 text-sm font-medium transition-colors">Cancel</button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white w-full rounded-xl py-2.5 text-sm font-medium transition-colors shadow-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteUserName').textContent = name;
    document.getElementById('deleteForm').action = '/management/users/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection