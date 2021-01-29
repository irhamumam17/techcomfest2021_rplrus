<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class MatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fields = \App\Match::with('user')->with('field')->orderBy('created_at', 'DESC')->where('user_id', '!=', $request->id)->get();

        return response()->json([
            'data' => $fields
        ]);
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
      $new_match = new \App\Match;

      $new_match->date = $request->get('date');
      $new_match->user_id = $request->get('user_id');
      $new_match->field_id = $request->get('field_id');
      $new_match->teamReq = $request->get('teamReq');
      $new_match->teamAcc = $request->get('teamAcc');

      $new_match->save();

      return response()->json([
          'status' => 'success'
      ]);
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
        //
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
        $match = \App\Match::with('user')->findOrFail($id);

        $match->teamAcc = $request->get('teamAcc');
        $match->status = 'ACCEPT';

        $token = $match->user->token;

        $title = "Request Match Diterima";
        $body = "Hore! Request Match kamu telah diterima";

        $this->sendNotification($token, $title, $body);

        $match->save();

        return response()->json([
            'data' => $match
        ]);
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

    public function myMatch(Request $request)
    {
        $fields = \App\Match::with('user')->with('field')->orderBy('created_at', 'DESC')->where('user_id', '=', $request->id)->get();

        return response()->json([
            'data' => $fields
        ]);
    }
}
