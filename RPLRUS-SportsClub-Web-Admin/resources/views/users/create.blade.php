@extends('layouts.global')

@section("title") User create @endsection

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
        action="{{route('users.store')}}"
        method="POST">

      @csrf

      <div class="form-group">
        <label for="name">Name</label>
        <input
        value="{{old('name')}}"
        class="form-control {{$errors->first('name') ? "is-invalid": ""}}"
        placeholder="Full Name"
        type="text"
        name="name"
        id="name"/>
        <div class="invalid-feedback">
          {{$errors->first('name')}}
        </div>
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input
        value="{{old('username')}}"
        class="form-control {{$errors->first('username') ? "is-invalid": ""}}"
        placeholder="username"
        type="text"
        name="username"
        id="username"/>
        <div class="invalid-feedback">
          {{$errors->first('username')}}
        </div>
      </div>

      <div class="form-group">
        <label for="">Roles</label><br>
        <div class="custom-control custom-checkbox custom-control-inline {{$errors->first('roles') ? "is-invalid" : "" }}">
          <input type="checkbox" class="custom-control-input" name="roles[]" id="ADMIN" value="ADMIN">
          <label class="custom-control-label" for="ADMIN">Administrator</label>
        </div>

        <div class="custom-control custom-checkbox custom-control-inline {{$errors->first('roles') ? "is-invalid" : "" }}">
          <input type="checkbox" class="custom-control-input" id="STAFF" name="roles[]" value="STAFF">
          <label class="custom-control-label" for="STAFF">Staff</label>
        </div>

        <div class="custom-control custom-checkbox custom-control-inline {{$errors->first('roles') ? "is-invalid" : "" }}">
          <input type="checkbox" class="custom-control-input" id="CUSTOMER" name="roles[]" value="CUSTOMER">
          <label class="custom-control-label" for="CUSTOMER">Customer</label>
        </div>

        <div class="invalid-feedback">
          {{$errors->first('roles')}}
        </div>
      </div>

      <div class="form-group">
        <label for="phone">Phone number</label>
        <input
        value="{{old('phone')}}"
        type="text"
        name="phone"
        class="form-control {{$errors->first('phone') ? "is-invalid" : ""}}">
        <div class="invalid-feedback">
          {{$errors->first('phone')}}
        </div>
      </div>

      <div class="form-group">
        <label for="address">Address</label>
        <textarea
        name="address"
        id="address"
        class="form-control {{$errors->first('address') ? "is-invalid" : ""}}">{{old('address')}}</textarea>
        <div class="invalid-feedback">
          {{$errors->first('address')}}
        </div>
      </div>

      <div class="form-group">
        <label for="avatar">Avatar image</label>
        <div class="custom-file">
          <input name="avatar" type="file" class="custom-file-input {{$errors->first('avatar') ? "is-invalid" : ""}}" id="avatar">
          <label class="custom-file-label" for="avatar">Choose file</label>
          <div class="invalid-feedback">
            {{$errors->first('address')}}
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input
        value="{{old('email')}}"
        class="form-control {{$errors->first('email') ? "is-invalid" : ""}}"
        placeholder="user@mail.com"
        type="text"
        name="email"
        id="email"/>
        <div class="invalid-feedback">
          {{$errors->first('email')}}
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input
        class="form-control {{$errors->first('password') ? "is-invalid" : ""}}"
        placeholder="password"
        type="password"
        name="password"
        id="password"/>
        <div class="invalid-feedback">
          {{$errors->first('password')}}
        </div>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Password Confirmation</label>
        <input
        class="form-control {{$errors->first('password_confirmation') ? "is-invalid" : ""}}"
        placeholder="password confirmation"
        type="password"
        name="password_confirmation"
        id="password_confirmation"/>
        <div class="invalid-feedback">
          {{$errors->first('password_confirmation')}}
        </div>
      </div>

      <div class="text-right">
        <input
        class="btn btn-primary"
        type="submit"
        value="Save"/>
      </div>
    </form>
  </div>
</div>
@endsection
