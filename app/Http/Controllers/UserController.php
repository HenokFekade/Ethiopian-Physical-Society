<?php

namespace App\Http\Controllers;

use App\User;
use App\Field;
use Illuminate\Http\Request;

class UserController extends Controller
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
            $count = 1;
            $users = User::whereType('editor')->orWhere('type', 'chief editor')->orderBy('name', 'ASC')->get();
            return view('admin.user.index', compact('users', 'count'));
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
            $user = User::create([
                'name' => strtolower($request->name),
                'email' => $request->email,
                'type' => strtolower($request->type),
                'password' => \Hash::make($request['password']),
            ]);
            if ($request->type == 'editor') {
               
                $this->attachFieldUser($request->fields, $user);
            }
            return "success";

        } else {
            return view('pageNotFound');
        }
    }

    public function validater($data)
    {
        if ($data->type == 'editor') {
            $this->validate($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|string|max:255|unique:users',
                'fields' => 'required',
                'password' => 'required|string|min:8',
            ]);
        } else {
            $this->validate($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|string|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
        }
        
    }

    public function attachFieldUser($fields, $user)
    {
        foreach ($fields as $field) {
            $user->fields()->attach($this->findFieldId($field));
        }
    }

    public function findFieldId($field)
    {
        $field = Field::whereName($field)->first();
        return $field->id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (\Gate::allows('isAdmin')) {
            
            return redirect('/users')->with('status', 'user updated');
        } else {
            return view('pageNotFound');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (\Gate::allows('isAdmin')) {
            
            return redirect('/users')->with('status', 'user account deactivated');
        } else {
            return view('pageNotFound');
        }
    }
    
}
