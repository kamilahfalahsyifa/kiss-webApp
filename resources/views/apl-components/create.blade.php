@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Create APL Component</h1>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('apl-components.store') }}">
                @csrf

                <div class="form-control mb-4">
                    <label class="label"><span class="label-text">Name</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="input input-bordered @error('name') input-error @enderror" placeholder="Component name" />
                </div>

                <div class="form-control mb-6">
                    <label class="label"><span class="label-text">Description</span></label>
                    <textarea name="description" class="textarea textarea-bordered @error('description') textarea-error @enderror" rows="3" placeholder="Optional description">{{ old('description') }}</textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('apl-components.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
