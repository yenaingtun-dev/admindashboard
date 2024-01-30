@extends('layouts.app')
@section('content')
<div class="col">
      <div class="container px-5">
            @can('create_role')
                  <a href="{{ route('roles.create') }}">Create</a>
            @endcan
            <table class="table table-bordered">
                  <thead>
                        <tr>
                              <th scope="col">#</th>
                              <th scope="col">Title</th>
                              <th>Permission</th>
                              <th></th>
                              <th></th>
                        </tr>
                  </thead>
                  <tbody>
                        @foreach ($roles as $role)
                        <tr>
                              <th scope="row">{{ $role->id }}</th>
                              <td>{{ $role->title }}</td>
                              <td></td>
                              <td>
                                    @can('edit_role')
                                          <a class="btn btn-sm btn-info" href="{{ route('roles.edit', $role) }}">edit</a>
                                    @endcan
                              </td>
                              <td>
                                    @can('delete_role')
                                          <form action="{{ route('roles.destroy',$role) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit">delete</button>
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