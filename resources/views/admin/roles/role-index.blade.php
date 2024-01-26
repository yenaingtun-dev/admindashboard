@extends('layouts.app')

@section('content')
<div class="col">
      <div class="container px-5">
            <table class="table table-bordered">
                  <thead>
                        <tr>
                              <th scope="col">#</th>
                              <th scope="col">Title</th>
                        </tr>
                  </thead>
                  <tbody>
                        @foreach ($roles as $role)
                        <tr>
                              <th scope="row">{{ $role->id }}</th>
                              <td>{{ $role->title }}</td>
                              <td></td>
                        </tr>
                        @endforeach
                  </tbody>
            </table>
      </div>
</div>
@endsection