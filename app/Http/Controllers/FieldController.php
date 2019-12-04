<?php

namespace App\Http\Controllers;

use App\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FieldController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin')) {
            $fields = Field::orderBy('name', 'ASC')->get();
            $count = 1;
            return view('admin.field.index', compact('fields', 'count'));
        } else {
            return view('pageNotFound');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Gate::allows('isAdmin')) {
            return view('admin.field.create');
        } else {
            return view('pageNotFound');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Gate::allows('isAdmin')) {
            $this->validater($request);
            DB::beginTransaction();
            try {
                Field::create([
                    'name' => strtolower($request->name),
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }


            return redirect('/fields')->with('status', 'field created');
        } else {
            return view('pageNotFound');
        }

    }

    public function validater($data)
    {
        $this->validate($data, [
            'name' => 'required|string|max:255|unique:fields',
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        if (\Gate::allows('isAdmin')) {
            return view('admin.field.edit', compact('field'));
        } else {
            return view('pageNotFound');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        if (\Gate::allows('isAdmin')) {
            $this->validater($request);
            DB::beginTransaction();
            try {
                $field->update([
                    'name' => strtolower($request->name),
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
            }
            return redirect('/fields')->with('status', 'field updated');

        } else {
            return view('pageNotFound');
        }
    }


    public function returnAllFields()
    {
        if (\Gate::allows('isAdmin')) {
            $fields = Field::orderBy('name', 'ASC')->get();
            return $fields;
        } else {
            return view('pageNotFound');
        }

    }
}
