@extends('layouts.authenticated')

@section('main')
<div class='space-y-4'>
    <h1 class='text-2xl font-bold'>Edit APL Component</h1>
    <div class='card bg-base-100 shadow'>
        <div class='card-body'>
            <form method='POST' action='{{ route('apl-components.update', $component->id) }}'>
                @csrf
                @method('PUT')
                <div class='form-control mb-4'>
                    <label class='label'><span class='label-text'>Name</span></label>
                    <input type='text' name='name' value='{{ old('name', $component->name) }}' required class='input input-bordered' />
                </div>
                <div class='form-control mb-6'>
                    <label class='label'><span class='label-text'>Description</span></label>
                    <textarea name='description' class='textarea textarea-bordered' rows='3'>{{ old('description', $component->description) }}</textarea>
                </div>
                <button type='submit' class='btn btn-primary'>Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
