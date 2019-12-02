<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        if (\Gate::allows('isAdmin')) {
            $count = 1;
            $num = 1;
            $activeUsers = \App\User::whereType('editor')->orWhere('type', 'chief editor')->orderBy('name', 'ASC')->get();
            $deactiveUsers = \App\User::onlyTrashed()->orderBy('name', 'ASC')->get();
            return view('admin.home', compact('activeUsers', 'deactiveUsers', 'num', 'count'));
        }
        else {
            return view('pageNotFound');
        }
    }

}
