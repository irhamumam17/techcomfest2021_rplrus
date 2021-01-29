@extends('layouts.global')

@section("title") Schedules list @endsection

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
      <form action="{{route('schedules.index')}}">
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
        <a href="{{route('schedules.create')}}" class="btn btn-primary">Add schedule</a>
    </div><br>
    <div class="table-responsive">
      <table class="table table-bordered table-md">
        <tr>
          <th>Date</th>
          <th>Field</th>
          <th>Reason</th>
        </tr>
        @foreach($schedules as $schedule)
        <tr>
          <td>{{$schedule->date}}</td>
          <td>{{$schedule->field->name}}</td>
          <td>{{$schedule->reason}}</td>
        @endforeach
      </table>
    </div>
  </div>

  <div class="card-footer text-right">
    <nav class="d-inline-block">
      <tr>
        <td colspan=10>
          {{$schedules->links()}}
        </td>
      </tr>
    </nav>
  </div>
</div>
@endsection
