<?php

namespace App\Http\Controllers;

use App\User;
use App\Field;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Mail\UserDetailMail;
use Illuminate\Support\Facades\Mail;

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
            return view('admin.user.index');
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
            $this->createValidater($request);
            $user = User::create([
                'name' => strtolower($request->name),
                'email' => $request->email,
                'type' => strtolower($request->type),
                'password' => \Hash::make($request['password']),
            ]);
            if ($request->type == 'editor') {

                $this->attachFieldToUser($request->fields, $user);
            }
            $this->createEventToSendEmailVerification($user);
            $this->sendUserDetailMail($request);
            return "success";

        } else {
            return view('pageNotFound');
        }
    }

    public function createValidater($data)
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

    public function attachFieldToUser($fields, $user)
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

    public function sendUserDetailMail($user)
    {
      Mail::to($user->email)->send(new UserDetailMail($user));
    }

    public function createEventToSendEmailVerification($user)
    {
      event(new Registered($user));
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
            $this->updateValidater($request, $user);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'type' => strtolower($request->type),
            ]);
            if (!empty($request->password)) {
                $user->update([
                    'password' => \Hash::make($request->password),
                ]);
            }

            if ($request->type == 'editor') {
                $this->attachFieldToUser($request->fields, $user);
            }
        } else {

        }
    }

    public function updateValidater($data, $user)
    {
        if ($data->type == 'editor') {
            $this->validate($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'fields' => 'required',
            ]);
        } else {
            $this->validate($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            ]);
        }

        if (!empty($data->password)) {
            $this->validate($data, [
                'password' => 'required|string|min:8',
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function deactivateAccount($id)
    {
        $user = User::findOrFail($id);
        if (\Gate::allows('isAdmin')) {
            if($this->checkURL())
            {
                $user->delete();
                return redirect()->back();
            } else {
                $user->delete();
            }
        } else {

        }
    }

    public function checkURL()
    {
        try {
            $temp = explode('/', $_SERVER['HTTP_REFERER']);
            if($temp[(count($temp )- 1)] == "home")
            {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $e) {
            return true;
        }
    }


    public function returnAllUsers()
    {
        if (\Gate::allows('isAdmin')) {
            $users = User::whereType('editor')->orWhere('type', 'chief editor')->orderBy('name', 'ASC')->get();
            $users = $this->attachField($users);
            $users = $this->userNameCapitalize($users);
            $users = $this->attachNumber($users);
            return $users;
        }
    }

    public function attachField($users)
    {
        foreach ($users as $user) {
            $user['fields'] = $user->fields;
        }
        return $users;
    }

    public function userNameCapitalize($users)
    {
        foreach ($users as $user) {
            $user->name = ucwords($user->name);
        }
        return $users;
    }

    public function attachNumber($users)
    {
        $count = 1;
        foreach ($users as $user) {
            $user->count = $count++;
        }
        return $users;
    }

    public function activateAccount($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        if(\Gate::allows('isAdmin'))
        {
            if($this->checkURL())
            {
                $user->restore();
                return redirect()->back();
            }
            else
            {
               $user->restore();
            }
        }
        else {

        }
    }

}
