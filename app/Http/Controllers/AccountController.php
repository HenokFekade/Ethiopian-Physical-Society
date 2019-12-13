<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserActivateMail;
use App\Mail\UserDeactivateMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            auth()->user()->update([
                'name' => strtolower($request->name),
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
              $this->updateEmailVerifiedAtColumn(auth()->user());
              $this->createEventToSendEmailVerification();

            }
            DB::commit();
            return redirect('/home')->with('status', 'account updated');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('status', 'something went wrong');
        }
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

    public function updateEmailVerifiedAtColumn($user)
    {
      $user->forceFill([
        'email_verified_at' => null,
      ])->save();
    }

    public function activateAccount($id)
    {

        if(\Gate::allows('isAdmin'))
        {
            $user = User::onlyTrashed()->findOrFail($id);
            DB::beginTransaction();

                $user->restore();
                $this->updateEmailVerifiedAtColumn($user);
                $this->sendActivatedMail($user);
                DB::commit();
                return "success";


        }
        else {

        }
    }


    public function sendActivatedMail($user)
    {
      Mail::to($user->email)->send(new UserActivateMail($user));
    }

    public function deactivateAccount($id)
    {
        $user = User::findOrFail($id);
        if (\Gate::allows('isAdmin')) {
                DB::beginTransaction();
                try {
                    $user->delete();
                    $this->updateEmailVerifiedAtColumn($user);
                    $this->sendDeactivationMail($user);
                    DB::commit();
                    return "success";
                } catch (\Exception $e) {
                    DB::rollback();
                    return "error";
                }

        } else {

        }
    }

    public function sendDeactivationMail($user)
    {
        Mail::to($user->email)->send(new UserDeactivateMail($user));
    }

}
