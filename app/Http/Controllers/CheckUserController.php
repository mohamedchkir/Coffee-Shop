<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserController extends Controller
{
    function checkRole(){
        if (auth()->user()->is_admin ==1) {
            return view('admin.index');
        }else {
            Auth::logout();
            return abort(403);

        }
    }
}
