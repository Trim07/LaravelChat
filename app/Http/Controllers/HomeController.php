<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('home');
    }

    public function getUsers(){
        return User::select('id', 'name')->where('id', "!=", Auth::user()->id)->get();
    }
}
