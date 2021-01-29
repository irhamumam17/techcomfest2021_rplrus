<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
       // OTORISASI GATE

      $this->middleware(function($request, $next){

        if(Gate::allows('manage-bookings')) return $next($request);

        abort(403, 'Anda tidak memiliki cukup hak akses');
      }, ['except' => ['unavailableTime', 'store', 'bookings']]);
    }

    public function index(Request $request)
    {
      $keyword = $request->get('keyword') ? $request->get('keyword') : '';
      $bookings = \App\Booking::with('user')
                    ->with('field')
                    ->whereHas('user', function($query) use ($keyword) {
                        $query->where('name', 'LIKE', "%$keyword%");
                      })->orderBy('created_at', 'DESC')
                    ->paginate(10);

      return view('bookings.index', ['bookings' => $bookings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $status = "error";
      $message = "";
      $data = null;
      $code = 400;

      $booking = \App\Booking::create([
          'user_id' => $request->user_id,
          'field_id' => $request->field_id,
          'date' => $request->date,
          'time' => $request->time,
          'total_price' => $request->total_price,
      ]);

      if($booking){
          $status = "success";
          $message = "booking successfully";
          $data = $booking->toArray();
          $code = 200;
      }
      else{
          $message = 'booking failed';
      }

      return response()->json([
          'status' => $status,
          'message' => $message,
          'data' => $data
      ], $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $booking = \App\Booking::findOrFail($id);

      return view('bookings.edit', ['booking' => $booking]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $booking = \App\Booking::with('user')->findOrFail($id);

      $booking->status = $request->get('status');
      $token = $booking->user->token;

      $char="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
      $random = substr(str_shuffle($char), 0, 4);

      $title = "Pesanan Dibatalkan";
      $body = "Pesanan kamu telah dibatalkan";

      if($request->get('status') == 'ACCEPT'){
        $booking->code = date('ymd', strtotime($booking->date)) . $random;

        $title = "Pesanan Diterima";
        $body = "Hore! Pesanan kamu telah diterima";
      }

      $this->sendNotification($token, $title, $body);
      
      $booking->save();

      return redirect()->route('bookings.edit', [$booking->id])->with('status', 'Booking status succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function unavailableTime(Request $request)
    {
      $bookings = \App\Booking::where('field_id', $request->id)->where('date', $request->date)->get();

      $times = [];
      foreach ($bookings as $booking) {
        $time = json_decode($booking->time);
        $times[] = $time;
      }

      $merged = [];
      for ($i=0; $i < count($times); $i++) {
        $merged = array_merge($merged, $times[$i]);
      }

      $unavailable[] = ['unavailable' => json_encode($merged)];

      return response()->json([
        'data' => $merged
      ]);
    }

    public function bookings(Request $request)
    {
      $bookings = \App\Booking::with('field')->where('user_id', $request->id)->orderBy('created_at', 'DESC')->get();

      // $bookings->field->name

      $data = $bookings->toArray();

      return response()->json([
          'data' => $data
      ]);
    }

    public function sendNotification($token, $title, $body)
    {
      $optionBuilder = new OptionsBuilder();
      $optionBuilder->setTimeToLive(60*20);

      $notificationBuilder = new PayloadNotificationBuilder($title);
      $notificationBuilder->setBody($body)
                  ->setSound('default');

      $dataBuilder = new PayloadDataBuilder();
      $dataBuilder->addData(['a_data' => 'my_data']);

      $option = $optionBuilder->build();
      $notification = $notificationBuilder->build();
      $data = $dataBuilder->build();

      $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

      $downstreamResponse->numberSuccess();
      $downstreamResponse->numberFailure();
      $downstreamResponse->numberModification();
    }
}
