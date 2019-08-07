<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\DB;
use View;

class ProfileController extends Controller
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
        $user = auth()->user();
        return view::make('profile', compact('user'));
    }
    public function profile()
    {
        if (isset($_POST['save'])){
            $user = auth()->user();

            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            $user->name = $name;
            $user->phone = $phone;
            $user->address = $address;
            $user->save();

            return view::make('profile', compact('user'));
        }
    }
}
