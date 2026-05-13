@extends('layouts.dashboard')

@section('page_title', 'Add User')
@section('page_subtitle', 'Create a new user')

@section('content')
<div class="max-w-full sm:max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <div class="flex items-center gap-3 mb-4 sm:mb-6">
            <a href="{{ route('management.users.index') }}" class="btn btn-ghost btn-sm px-2 sm:px-3 py-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800">Add New User</h2>
                <p class="text-gray-500 text-xs sm:text-sm">Create a new system user account</p>
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

        <form action="{{ route('management.users.store') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all"
                           placeholder="Enter full name">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all"
                           placeholder="Enter email address">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                    <select name="role" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all">
                        <option value="">Select Role</option>
                        <option value="mekanik" {{ old('role') === 'mekanik' ? 'selected' : '' }}>Mekanik</option>
                        <option value="planner" {{ old('role') === 'planner' ? 'selected' : '' }}>Planner</option>
                        <option value="gl" {{ old('role') === 'gl' ? 'selected' : '' }}>GL</option>
                        <option value="tere" {{ old('role') === 'tere' ? 'selected' : '' }}>TERE</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                    <input type="password" name="password" required minlength="8"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all"
                           placeholder="Minimum 8 characters">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all"
                           placeholder="Re-enter password">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 mt-6 sm:mt-8">
                <a href="{{ route('management.users.index') }}" class="btn btn-ghost flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl py-2.5 sm:py-3 text-sm font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="btn bg-maroon text-white hover:bg-maroon-dark flex-1 rounded-xl py-2.5 sm:py-3 text-sm font-medium transition-colors shadow-sm">
                    <i class="fas fa-save mr-2"></i> Save User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection