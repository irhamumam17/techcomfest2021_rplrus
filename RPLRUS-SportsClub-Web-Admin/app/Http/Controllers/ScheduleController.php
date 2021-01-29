<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
      // OTORISASI GATE

     $this->middleware(function($request, $next){

       if(Gate::allows('manage-schedules')) return $next($request);

       abort(403, 'Anda tidak memiliki cukup hak akses');
     });
    }

    public function index()
    {
      $schedules = \App\Schedule::paginate(10);
      return view('schedules.index', ['schedules' => $schedules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $fields = \App\Field::all();

      return view('schedules.create', ['fields' => $fields]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      \Validator::make($request->all(), [
          "date" => "required",
          "field" => "required",
          "reason" => "required",
      ])->validate();

      $new_schedule = new \App\Schedule;

      $new_schedule->field_id = $request->get('field');
      $new_schedule->date = $request->get('date');
      $new_schedule->reason = $request->get('reason');

      $new_schedule->save();

      return redirect()->route('schedules.create')->with('status', 'Schedule successfully added.');
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
        //
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
}
