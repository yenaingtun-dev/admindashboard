@extends('layouts.app')
@section('content')
<div class="col">
      <div class="container px-5">
            @can('create_user')
                  <a href="{{ route('users.create') }}">Create</a>
            @endcan
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
                              <td>
                                    <img src="{{ asset($user->profile_image_path) }}" alt="" class="w-25">
                              </td>
                              <td>{{ $user->name }}</td>
                              <td>{{ $user->email }}</td>
                              <td>
                                    @if ($user->roles)
                                          @foreach ($user->roles as $role)
                                                {{ $role->title }}
                                          @endforeach
                                    @endif
                              </td>
                              <td>
                                    @can('edit_user')
                                          <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info">edit</a>
                                    @endcan
                              </td> 
                              <td>
                                    @can('delete_user')
                                          <form action="{{ route('users.destroy', $user) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">delete</button>
                                          </form>
                                    @endcan
                              </td>
                        </tr>
                        @endforeach
                  </tbody>
            </table>
      </div>
</div>
@endsection