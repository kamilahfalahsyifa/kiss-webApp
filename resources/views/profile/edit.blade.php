@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <h1 class="text-2xl font-bold">Profile</h1>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Name</span></label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="input input-bordered @error('name') input-error @enderror" />
                    @error('name')
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="input input-bordered @error('email') input-error @enderror" />
                    @error('email')
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
