@extends('layouts.app')
@section('content')
<div class="col">
      <div class="container px-5">
            <h1>Create Branch</h1>
            <div class="container">
                  <form action="{{ route('branches.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                              <label for="name" class="form-label">Name</label>
                              <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name">
                              @error('name')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
                  </form>
            </div>
      </div>
</div>
@endsection
