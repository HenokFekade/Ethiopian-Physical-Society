<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\AdminConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('admin.editAccount');
    }

    public function update(Request $request)
    {
        $this->validater($request);
        $oldEmail = auth()->user()->email;
        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if(!empty($request->password))
        {
            auth()->user()->update([
                'password' => \Hash::make($request->password),
            ]);
        }
        if(auth()->user()->email != $oldEmail)
        {
          $this->updateEmailVerifiedAtColumn();
          $this->createEventToSendEmailVerification();

        }
        return redirect('/home')->with('status', 'account updated');
    }

    public function validater($data)
    {
        $this->validate($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|string|unique:users,email,'.auth()->user()->id,
        ]);
        if(!empty($data->password))
        {
            $this->validate($data, [
                'password' => 'required|string|min:8',
            ]);
        }
    }

    protected function createEventToSendEmailVerification()
    {
          event(new Registered(auth()->user()));
    }

    public function updateEmailVerifiedAtColumn()
    {
      auth()->user()->forceFill([
        'email_verified_at' => null,
      ])->save();
    }

}
