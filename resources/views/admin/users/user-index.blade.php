@extends('layouts.app')

@section('content')
<div class="col">
      <div class="container px-5">
            <table class="table table-bordered">
                  <thead>
                        <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Email</th>
                              <th scope="col">Role</th>
                        </tr>
                  </thead>
                  <tbody>
                        @foreach ($users as $user)
                        <tr>
                              <th scope="row">{{ $user->id }}</th>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->email }}</td>
                              <td></td>
                        </tr>
                        @endforeach
                  </tbody>
            </table>
      </div>
</div>
@endsection