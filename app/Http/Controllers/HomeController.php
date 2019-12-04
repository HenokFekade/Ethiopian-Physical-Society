<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (\Gate::allows('isAdmin'))
        {
            $count = 1;
            $num = 1;
            $activeUsers = User::whereType('editor')->orWhere('type', 'chief editor')->orderBy('name', 'ASC')->get();
            $deactiveUsers = User::onlyTrashed()->orderBy('name', 'ASC')->get();
            return view('admin.home', compact('activeUsers', 'deactiveUsers', 'num', 'count'));
        }
        else if(\Gate::allows('isEditor'))
        {
            $count = 1;
            $files = auth()->user()->files;
            return view('editor.home', compact('count', 'files'));
        }
        else
        {
            return view('pageNotFound');
        }
    }

}
