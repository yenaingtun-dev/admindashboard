@extends('layouts.app')

@section('content')
<div class="col">
      <div class="container px-5">
            <a href="{{ route('users.create') }}">Create</a>
            <table class="table table-bordered">
                  <thead>
                        <tr>
                              <th scope="col">#</th>
                              <th scope="col">Image</th>
                              <th scope="col">Name</th>
                              <th scope="col">Email</th>
                              <th scope="col">Role</th>
                              <th scope="col"></th>
                              <th scope="col"></th>
                        </tr>
                  </thead>
                  <tbody>
                        @foreach ($users as $user)
                        <tr>
                              <th scope="row">{{ $user->id }}</th>
                              <td></td>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->email }}</td>
                              <td></td>
                              <td>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info">edit</a>
                              </td>
                              <td>
                                    <form action="{{ route('users.destroy', $user) }}" method="post">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-sm btn-danger">delete</button>
                                    </form>
                              </td>
                        </tr>
                        @endforeach
                  </tbody>
            </table>
      </div>
</div>
@endsection