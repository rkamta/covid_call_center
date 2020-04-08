<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function welcome(Request $request)
    {
        $request->session()->put('page', 'welcome');
        return view('welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $request->session()->put('page', 'dashboard');
        $users = User::all();
        $data = array(
            'users'=> $users
        );
        return view('dashboard')->with($data);
    }
}
