@extends('layouts.app') 
@section('content')
<div class="col">
    <div class="container px-5">
        <h1>Edit Role</h1>
        <div class="container">
            <form action="{{ route('roles.update', $role) }}" method="POST" >
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title"
                        value="{{ old('title', $role->title) }}" />
                    @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if ($permissions)
                        @foreach ($permissions as $permission)
                            <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="{{ $permission->title }}"
                                        {{ (in_array($permission->id, old('permissions', [])) || $role->permissions->contains($permission->id)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $permission->title }}">
                                                {{ $permission->title }}
                                        </label>
                                    </div>
                            </div>
                        @endforeach
                @endif
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection