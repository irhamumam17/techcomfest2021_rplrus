@extends('layouts.global')

@section("title") Users list @endsection

@section("pageTitle") Users list @endsection

@section('content')
@if(session('status'))
<div class="alert alert-success">
  {{session('status')}}
</div>
@endif
<div class="card">
  <div class="card-header">
    <h4></h4>
    <div class="card-header-form">
      <!-- <form action="{{route('users.index')}}">
              <input
                value="{{Request::get('keyword')}}"
                name="keyword"
                class="form-control"
                type="text"
                placeholder="Masukan email untuk filter..."/>
            <div class="custom-control custom-radio custom-control-inline">
              <input {{Request::get('status') == 'ACTIVE' ? 'checked' : ''}}
                value="ACTIVE"
                name="status"
                type="radio"
                class="custom-control-input"
                id="active">
                <label class="custom-control-label" for="active">Active</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input {{Request::get('status') == 'INACTIVE' ? 'checked' : ''}}
                value="INACTIVE"
                name="status"
                type="radio"
                class="custom-control-input"
                id="inactive">
                <label class="custom-control-label" for="inactive">Inactive</label>
            </div>

              <input
                type="submit"
                value="Filter"
                class="btn btn-primary">
      </form> -->
        <form action="{{route('users.index')}}">
          <div class="card-header-form custom-control-inline">
            <div class="custom-control custom-radio custom-control-inline">
              <input {{Request::get('status') == 'ACTIVE' ? 'checked' : ''}}
                value="ACTIVE"
                name="status"
                type="radio"
                class="custom-control-input"
                id="active">
                <label class="custom-control-label" for="active">Active</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input {{Request::get('status') == 'INACTIVE' ? 'checked' : ''}}
                value="INACTIVE"
                name="status"
                type="radio"
                class="custom-control-input"
                id="inactive">
                <label class="custom-control-label" for="inactive">Inactive</label>
            </div>
          <div class="input-group">
            <input name="keyword" value="{{Request::get('keyword')}}" type="text" class="form-control" placeholder="Masukan email untuk filter...">
            <div class="input-group-btn">
              <button class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="col-md-12 text-right">
        <a href="{{route('users.create')}}" class="btn btn-primary">Create user</a>
    </div><br>
    <div class="table-responsive">
      <table class="table table-bordered table-md">
        <tr>
          <!-- <th>#</th> -->
          <th>#</th>
          <th>Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Avatar</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
        @foreach($users as $user)
        <tr>
          <td>{{$loop->iteration + $users->firstItem() - 1}}</td>
          <td>{{$user->name}}</td>
          <td>{{$user->username}}</td>
          <td>{{$user->email}}</td>
          <td>
          @if($user->avatar)
            <img src="{{asset('storage/'.$user->avatar)}}" width="70px"/>
          @else
            N/A
          @endif
          </td>
          <td>
            @if($user->status == "ACTIVE")
              <span class="badge badge-success">
                {{$user->status}}
              </span>
            @else
              <span class="badge badge-danger">
                {{$user->status}}
              </span>
            @endif
          </td>
          <td>
            <a href="{{route('users.edit', [$user->id])}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
            <a href="{{route('users.show', [$user->id])}}" class="btn btn-secondary" data-toggle="tooltip" title="Detail"><i class="fas fa-info-circle"></i></a>
            <form onsubmit="return confirm('Delete this user permanently?')" id="formDelete" class="custom-control-inline" action="{{route('users.destroy', [$user->id])}}" method="POST">
                @csrf
                <input
                      type="hidden"
                      name="_method"
                      value="DELETE">

                <button class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
  <div class="card-footer text-right">
    <nav class="d-inline-block">
      <tr>
        <td colspan=10>
          {{$users->appends(Request::all())->links()}}
        </td>
      </tr>
    </nav>
  </div>
</div>
@endsection
