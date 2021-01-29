@extends('layouts.global')

@section("title") Schedule create @endsection

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
    action="{{route('schedules.store')}}"
    method="POST">

    @csrf

    <div class="form-group">
      <label for="date">Date</label>
      <input
      value="{{old('date')}}"
      class="form-control datepicker {{$errors->first('date') ? "is-invalid": ""}}"
      type="text"
      name="date"/>
      <div class="invalid-feedback">
        {{$errors->first('date')}}
      </div>
    </div>

    <div class="form-group">
      <label for="field">Field</label>
      <select name="field" class="form-control {{$errors->first('field') ? "is-invalid": ""}}">
        <option selected>Choose...</option>
        <div class="invalid-feedback">
          {{$errors->first('field')}}
        </div>
        @foreach($fields as $field)
        <option value="{{$field->id}}">{{$field->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="reason">Reason</label>
      <textarea
      name="reason"
      id="reason"
      class="form-control {{$errors->first('reason') ? "is-invalid" : ""}}">{{old('reason')}}</textarea>
      <div class="invalid-feedback">
        {{$errors->first('reason')}}
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
@endsection
