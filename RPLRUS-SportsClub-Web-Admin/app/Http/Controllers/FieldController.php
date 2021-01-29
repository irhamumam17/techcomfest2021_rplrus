<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Fields as FieldCollectionResource;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
       // OTORISASI GATE

      $this->middleware(function($request, $next){

        if(Gate::allows('manage-fields')) return $next($request);

        abort(403, 'Anda tidak memiliki cukup hak akses');
      }, ['except' => ['fields', 'fieldAll']]);
    }

    public function index(Request $request)
    {
      $keyword = $request->get('keyword') ? $request->get('keyword') : '';
      $fields = \App\Field::where("name", "LIKE", "%$keyword%")->paginate(10);

      return view('fields.index', ['fields' => $fields]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('fields.create');
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
        "name" => "required|min:5|max:200",
        "category" => "required",
        "location" => "required",
        "open" => "required",
        "address" => "required",
        "price" => "required|digits_between:0,10",
        "close" => "required",
        "picture" => "required",
      ])->validate();

      $new_field = new \App\Field;

      $new_field->name = $request->get('name');
      $new_field->category = $request->get('category');
      $new_field->open = $request->get('open');
      $new_field->close = $request->get('close');
      $new_field->price = $request->get('price');
      $new_field->location = $request->get('location');
      $new_field->address = $request->get('address');

      if($request->file('picture')){
          $file = $request->file('picture')->store('pictures', 'public');

          $new_field->picture = $file;
      }

      $new_field->save();

      return redirect()->route('fields.create')->with('status', 'Field successfully added.');
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
      $field = \App\Field::findOrFail($id);

      return view('fields.edit', ['field' => $field]);
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
      \Validator::make($request->all(), [
        "name" => "required|min:5|max:200",
        "category" => "required",
        "location" => "required",
        "open" => "required",
        "address" => "required",
        "price" => "required|digits_between:0,10",
        "close" => "required",
      ])->validate();

      $field = \App\Field::findOrFail($id);

      $field->name = $request->get('name');
      $field->category = $request->get('category');
      $field->open = $request->get('open');
      $field->close = $request->get('close');
      $field->location = $request->get('location');
      $field->price = $request->get('price');
      $field->address = $request->get('address');

      if($request->file('picture')){
          if($field->picture && file_exists(storage_path('app/public/' . $field->picture))){
              \Storage::delete('public/' . $field->picture);
          }
          $file = $request->file('picture')->store('pictures', 'public');
          $field->picture = $file;
      }

      $field->save();

      return redirect()->route('fields.edit', [$id])->with('status', 'Field succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $field = \App\Field::findOrFail($id);

      if($field->picture && file_exists(storage_path('app/public/' . $field->picture))){
        \Storage::delete('public/' . $field->picture);
      }

      $field->delete();

      return redirect()->route('fields.index')->with('status', 'Field successfully delete');
    }

    public function fields(Request $request)
    {
        $fields = new FieldCollectionResource(\App\Field::where('category', $request->category)->get());
        return $fields;
    }

    public function fieldAll(Request $request)
    {
        $fields = new FieldCollectionResource(\App\Field::get());
        return $fields;
    }
}
