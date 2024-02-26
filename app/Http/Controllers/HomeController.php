<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

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
        //        phpinfo();
        if (\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('auth.login');
        }
    }

    public function view()
    {
        return view('home');
    }

    public function lang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
        }

        return redirect()->back();
    }

    public function mode($mode)
    {

        Session::put('change_mode', $mode);

        return redirect()->back();
    }
}
