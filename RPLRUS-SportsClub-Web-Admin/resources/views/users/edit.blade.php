@extends('layouts.global')

@section('pageTitle') Edit User @endsection

@section('title') Edit User @endsection

@section('content')
<div class="col-md-8">

  @if(session('status'))
  <div class="alert alert-success">
    {{session('status')}}
  </div>
  @endif

  <form
    enctype="multipart/form-data"
    class="bg-white shadow-sm p-3"
    action="{{route('users.update', [$user->id])}}"
    method="POST">

    @csrf
    <input type="hidden" value="PUT" name="_method">

    <div class="form-group">
      <label for="name">Name</label>
      <input
        value="{{old('name') ? old('name') : $user->name}}"
        class="form-control {{$errors->first('name') ? "is-invalid" : ""}}"
        placeholder="Full Name"
        type="text"
        name="name"
        id="name"/>
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input
        value="{{$user->username}}"
        disabled
        class="form-control"
        placeholder="username"
        type="text"
        name="username"
        id="username"/>
    </div>

    <div class="form-group">
      <label for="">Status</label><br/>
      <div class="custom-control custom-radio custom-control-inline">
        <input {{$user->status == "ACTIVE" ? "checked" : ""}} value="ACTIVE" type="radio" id="active" name="status" class="custom-control-input">
        <label class="custom-control-label" for="active">Active</label>
      </div>

      <div class="custom-control custom-radio custom-control-inline">
        <input {{$user->status == "INACTIVE" ? "checked" : ""}} value="INACTIVE" type="radio" id="inactive" name="status" class="custom-control-input">
        <label class="custom-control-label" for="inactive">Inactive</label>
      </div>
    </div>

    <div class="form-group">
      <label for="">Roles</label><br>
      <div class="custom-control custom-checkbox custom-control-inline">
        <input
        type="checkbox" {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}}
        name="roles[]"
        class="custom-control-input {{$errors->first('roles') ? "is-invalid" : "" }}"
        id="ADMIN"
        value="ADMIN">
        <label class="custom-control-label" for="ADMIN">Administrator</label>
      </div>

      <div class="custom-control custom-checkbox custom-control-inline">
        <input
        type="checkbox" {{in_array("STAFF", json_decode($user->roles)) ? "checked" : ""}}
        name="roles[]"
        class="custom-control-input {{$errors->first('roles') ? "is-invalid" : "" }}"
        id="STAFF"
        value="STAFF">
        <label class="custom-control-label" for="STAFF">Staff</label>
      </div>

      <div class="custom-control custom-checkbox custom-control-inline">
        <input
          type="checkbox" {{in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : ""}}
          name="roles[]"
          class="custom-control-input {{$errors->first('roles') ? "is-invalid" : "" }}"
          id="CUSTOMER"
          value="CUSTOMER">
        <label class="custom-control-label" for="CUSTOMER">Customer</label>
      </div>
    </div>

    <div class="form-group">
      <label for="phone">Phone number</label>
      <input
        type="text"
        name="phone"
        class= "form-control {{$errors->first('phone') ? "is-invalid" : ""}}"
        value="{{old('phone') ? old('phone') : $user->phone}}">
        <div class="invalid-feedback">
          {{$errors->first('phone')}}
        </div>
    </div>

    <div class="form-group">
      <label for="address">Address</label>
      <textarea
        name="address"
        id="address"
        class="form-control {{$errors->first('address') ? "is-invalid" : ""}}">{{old('address') ? old('address') : $user->address}}
      </textarea>
      <div class="invalid-feedback">
        {{$errors->first('address')}}
      </div>
    </div>

    <div class="form-group">
      <label for="avatar">Avatar image</label><br>
      Current avatar: <br>
      @if($user->avatar)
        <img
          src="{{asset('storage/'.$user->avatar)}}"
          width="120px" />
        <br>
      @else
        <br>No avatar<br>
      @endif
      <br>
      <div class="custom-file">
        <input id="avatar" name="avatar" type="file" class="custom-file-input">
        <label class="custom-file-label" for="avatar">Choose file</label>
      </div>

      <small
        class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
     <input
       value="{{$user->email}}"
       disabled
       class="form-control"
       placeholder="user@mail.com"
       type="text"
       name="email"
       id="email"/>
    </div>
    <div class="text-right">
      <input
        class="btn btn-primary "
        type="submit"
        value="Save"/>
    </div>
  </form>
</div>
@endsection
