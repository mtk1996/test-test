<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderGroup;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $cre = $request->only('email', 'password'); // ['email'=>'','password'=>'']
        if (auth()->attempt($cre)) {
            //login
            $user =  auth()->user(); //role
            if ($user->role === 'user') {
                auth()->logout();
                return redirect()->back()->with('error', 'You Are Not Admin');
            }
            //
            return redirect('/admin/')->with('success', 'Welcome Admin');
        }
        ///wrong email and password
    }

    public function home()
    {

        $jan =  OrderGroup::whereYear('order_date', '2022')
            ->whereMonth('order_date', 1)
            ->count();
        $feb =  OrderGroup::whereYear('order_date', '2022')
            ->whereMonth('order_date', 2)
            ->count();
        $march =  OrderGroup::whereYear('order_date', '2022')
            ->whereMonth('order_date', 3)
            ->count();
        $ap =  OrderGroup::whereYear('order_date', '2022')
            ->whereMonth('order_date', 4)
            ->count();
        $may =  OrderGroup::whereYear('order_date', '2022')
            ->whereMonth('order_date', 5)
            ->count();
        $june =  OrderGroup::whereYear('order_date', '2022')
            ->whereMonth('order_date', 6)
            ->count();
        $data = [$jan, $feb, $march, $ap, $may, $june];


        $user = User::where('role', 'user')->latest()->take(5)->get();

        return view('admin.home', compact('data', 'user'));
    }
}
