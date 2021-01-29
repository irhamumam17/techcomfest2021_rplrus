  @extends('layouts.global')

  @section("title") Bookings list @endsection

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
        <form action="{{route('bookings.index')}}">
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
      <div class="table-responsive">
        <table class="table table-bordered table-md">
          <tr>
            <th>Code</th>
            <th>Status</th>
            <th>Customer</th>
            <th>Field</th>
            <th>Date</th>
            <th>Time</th>
            <th>Total Price</th>
            <th>Action</th>
          </tr>
          @foreach($bookings as $booking)
          <tr>
            <td>{{$booking->code}}</td>
            <td>
              @if($booking->status == "PENDING")
               <span class="badge bg-info text-light">{{$booking->status}}</span>
              @elseif($booking->status == "ACCEPT")
               <span class="badge bg-success text-light">{{$booking->status}}</span>
              @elseif($booking->status == "REJECT")
               <span class="badge bg-dark text-light">{{$booking->status}}</span>
              @endif
            </td>
            <td>{{$booking->user->name}}<br><small>{{$booking->user->email}}</small></td>
            <td>{{$booking->field->name}}</td>
            <td>
              {{$booking->date}}
            </td>
            <td>
              @if (count(json_decode($booking->time)) > 1)
                @foreach (json_decode($booking->time) as $time)
                  @if ($loop->first)
                    {{$time}} -
                  @endif
                @endforeach
                @foreach (json_decode($booking->time) as $time)
                  @if ($loop->last)
                    {{$time}}
                  @endif
                @endforeach
                @else
                @foreach (json_decode($booking->time) as $time)
                    {{$time}}
                @endforeach
              @endif
            </td>
            <td>{{$booking->total_price}}</td>
            <td>
              <a href="{{route('bookings.edit', [$booking->id])}}" class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit"><i class="fas fa-pencil-alt"></i></a>
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
            {{$bookings->links()}}
          </td>
        </tr>
      </nav>
    </div>
  </div>
  @endsection
