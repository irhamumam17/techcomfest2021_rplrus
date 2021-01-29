@extends('layouts.global')

@section("title") Edit Booking @endsection

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
    action="{{route('bookings.update', [$booking->id])}}"
    method="POST">

    @csrf
    <input type="hidden" value="PUT" name="_method">

    <div class="form-group">
      <label for="name">Code</label>
      <input
      value="{{$booking->code}}"
      class="form-control {{$errors->first('name') ? "is-invalid": ""}}"
      type="text"
      name="name"
      id="name"
      disabled/>
      <div class="invalid-feedback">
        {{$errors->first('code')}}
      </div>
    </div>

    <div class="form-group">
      <label for="customer">Customer</label>
      <input
      value="{{$booking->user->name}}"
      class="form-control {{$errors->first('location') ? "is-invalid": ""}}"
      type="text"
      name="customer"
      disabled/>
      <div class="invalid-feedback">
        {{$errors->first('customer')}}
      </div>
    </div>

    <div class="form-group">
      <label for="field">Field</label>
      <input
      value="{{$booking->field->name}}"
      class="form-control {{$errors->first('field') ? "is-invalid": ""}}"
      type="text"
      name="field"
      disabled/>
      <div class="invalid-feedback">
        {{$errors->first('field')}}
      </div>
    </div>

    <div class="form-group">
      <label for="date">Date</label>
      <input
      value="{{$booking->date}}"
      class="form-control {{$errors->first('date') ? "is-invalid": ""}}"
      type="text"
      name="date"
      disabled/>
      <div class="invalid-feedback">
        {{$errors->first('date')}}
      </div>
    </div>

    <div class="form-group">
      <label for="time">Time</label>
      <input
      value="@foreach (json_decode($booking->time) as $t){{$t}}@endforeach"
      class="form-control {{$errors->first('date') ? "is-invalid": ""}}"
      type="text"
      name="date"
      disabled/>
      <div class="invalid-feedback">
        {{$errors->first('date')}}
      </div>
    </div>

    <div class="form-group">
      <label for="total_price">Price</label> <br>
      <input value="{{$booking->total_price}}" type="text" class="form-control {{$errors->first('price') ? "is-invalid" : ""}}" name="total_price" disabled>
      <div class="invalid-feedback">
        {{$errors->first('total_price')}}
      </div>
    </div>

    <div class="form-group">
      <label for="status">Status</label><br>
      <select class="form-control" name="status" id="status" @if($booking->status == "ACCEPT" || $booking->status == "REJECT") disabled @endif>
        <option {{$booking->status == "PENDING" ? "selected" : ""}} value="PENDING">PENDING</option>
        <option {{$booking->status == "ACCEPT" ? "selected" : ""}} value="ACCEPT">ACCEPT</option>
        <option {{$booking->status == "REJECT" ? "selected" : ""}} value="REJECT">REJECT</option>
      </select>
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
