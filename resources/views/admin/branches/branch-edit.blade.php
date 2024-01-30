@extends('layouts.app') 
@section('content')
<div class="col">
    <div class="container px-5">
        <h1>Edit Branch</h1>
        <div class="container">
            <form action="{{ route('branches.update', $branch) }}" method="POST" >
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $branch->name) }}" />
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection