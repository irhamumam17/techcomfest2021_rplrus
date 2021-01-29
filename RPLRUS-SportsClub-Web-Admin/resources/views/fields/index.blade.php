@extends('layouts.global')

@section("title") Fields list @endsection

@section("pageTitle") Fields list @endsection

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
      <form action="{{route('fields.index')}}">
        <div class="input-group">
          <input name="keyword" value="{{Request::get('keyword')}}" type="text" class="form-control" placeholder="Search">
          <div class="input-group-btn">
            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="card-body">
    <div class="text-right">
        <a href="{{route('fields.create')}}" class="btn btn-primary">Add field</a>
    </div><br>
    <div class="table-responsive">
      <table class="table table-bordered table-md">
        <tr>
          <!-- <th>#</th> -->
          <th>Picture</th>
          <th>Name</th>
          <th>Category</th>
          <th>Open</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
        @foreach($fields as $field)
        <tr>
          <td>
          @if($field->picture)
            <img src="{{asset('storage/'.$field->picture)}}" width="70px"/>
          @else
            N/A
          @endif
          </td>
          <td>{{$field->name}}</td>
          <td>{{$field->category}}</td>
          <td>{{$field->open}} - {{$field->close}}</td>
          <td>{{$field->price}}</td>
          <td>
            <a href="{{route('fields.edit', [$field->id])}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
            <form onsubmit="return confirm('Delete this user permanently?')" class="custom-control-inline" action="{{route('fields.destroy', [$field->id])}}" method="POST">
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
          {{$fields->links()}}
        </td>
      </tr>
    </nav>
  </div>
</div>
@endsection
