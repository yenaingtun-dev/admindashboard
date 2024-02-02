@extends('layouts.app') 
@section('content')
<div class="col">
    <div class="container px-5">
        <h1>Edit Permission</h1>
        <div class="container">
            <form action="{{ route('permissions.update', $permission) }}" method="POST" >
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title"
                        value="{{ old('title', $permission->title) }}" />
                    @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection