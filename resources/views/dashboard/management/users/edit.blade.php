@extends('layouts.dashboard')

@section('page_title', 'Edit User')
@section('page_subtitle', 'Update user account')

@section('content')
<div class="max-w-full sm:max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="flex items-center gap-3 mb-4 sm:mb-6">
            <a href="{{ route('management.users.index') }}" class="btn btn-ghost btn-sm px-2 sm:px-3 py-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800">Edit User</h2>
                <p class="text-gray-500 text-xs sm:text-sm">Update user account information</p>
            </div>
        </div>

        @if($errors->any())
        <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('management.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all"
                           placeholder="Enter full name">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all"
                           placeholder="Enter email address">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                    <select name="role" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all">
                        <option value="mekanik" {{ old('role', $user->role) === 'mekanik' ? 'selected' : '' }}>Mekanik</option>
                        <option value="planner" {{ old('role', $user->role) === 'planner' ? 'selected' : '' }}>Planner</option>
                        <option value="gl" {{ old('role', $user->role) === 'gl' ? 'selected' : '' }}>GL</option>
                        <option value="tere" {{ old('role', $user->role) === 'tere' ? 'selected' : '' }}>TERE</option>
                    </select>
                </div>

                <div class="border-t border-gray-200 pt-5">
                    <p class="text-sm text-gray-500 mb-3">Leave password fields empty to keep current password</p>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input type="password" name="password" minlength="8"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all"
                               placeholder="Minimum 8 characters">
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all"
                               placeholder="Re-enter new password">
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 mt-6 sm:mt-8">
                <a href="{{ route('management.users.index') }}" class="btn btn-ghost flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl py-2.5 sm:py-3 text-sm font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn bg-maroon text-white hover:bg-maroon-dark flex-1 rounded-xl py-2.5 sm:py-3 text-sm font-medium transition-colors shadow-sm">
                    <i class="fas fa-save mr-2"></i> Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection