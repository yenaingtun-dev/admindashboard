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
                    <input type="text" class="form-control" id="title" name="title"
                        value="{{ old('title', $role->title) }}" />
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection