@extends('layouts.app')
@section('content')
<div class="col">
      <div class="container px-5">
            @can('create_branch')
            <a href="{{ route('branches.create') }}">Create</a>
            @endcan
            <table class="table table-bordered">
                  <thead>
                        <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th></th>
                              <th></th>
                        </tr>
                  </thead>
                  <tbody>
                        @foreach ($branches as $branch)
                        <tr>
                              <th scope="row">{{ $branch->id }}</th>
                              <td>{{ $branch->name }}</td>
                              <td>
                                    @can('edit_branch')
                                    <a class="btn btn-sm btn-info" href="{{ route('branches.edit', $branch) }}">edit</a>
                                    @endcan
                              </td>
                              <td>
                                    @can('delete_branch')
                                    <form action="{{ route('branches.destroy',$branch) }}" method="post">
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