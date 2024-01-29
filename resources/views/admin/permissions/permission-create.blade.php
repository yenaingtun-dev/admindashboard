@extends('layouts.app')
@section('content')
<div class="col">
      <div class="container px-5">
            <h1>Create Permission</h1>
            <div class="container">
                  <form action="{{ route('permissions.store') }}" method="POST" >
                        @csrf
                        <div class="mb-3">
                              <label for="title" class="form-label">Title</label>
                              <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                  </form>
            </div>
      </div>
</div>
@endsection
