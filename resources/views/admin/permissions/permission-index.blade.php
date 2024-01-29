@extends('layouts.app')
@section('content')
<div class="col">
      <div class="container px-5">
            <a href="{{ route('permissions.create') }}">Create</a>
            <table class="table table-bordered">
                  <thead>
                        <tr>
                              <th scope="col">#</th>
                              <th scope="col">Title</th>
                              <th></th>
                              <th></th>
                        </tr>
                  </thead>
                  <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                              <th scope="row">{{ $permission->id }}</th>
                              <td>{{ $permission->title }}</td>
                              <td>
                                    <a class="btn btn-sm btn-info" href="{{ route('permissions.edit', $permission) }}">edit</a>
                              </td>
                              <td>
                                    <form action="{{ route('permissions.destroy',$permission) }}" method="post">
                                          @csrf
                                          @method('DELETE')
                                          <button class="btn btn-sm btn-danger" type="submit">delete</button>
                                    </form>
                              </td>
                        </tr>
                        @endforeach
                  </tbody>
            </table>
      </div>
</div>
@endsection