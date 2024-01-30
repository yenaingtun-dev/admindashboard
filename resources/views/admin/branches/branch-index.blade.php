@extends('layouts.app')
@section('content')
<div class="col">
      <div class="container px-5">
            <a href="{{ route('branches.create') }}">Create</a>
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
                              <td></td>
                              <td>
                                    <a class="btn btn-sm btn-info" href="{{ route('branches.edit', $branch) }}">edit</a>
                              </td>
                              <td>
                              <form action="{{ route('branches.destroy',$branch) }}" method="post">
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