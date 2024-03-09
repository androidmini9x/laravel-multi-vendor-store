<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthentcate extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('front.auth.two-factor', compact('user'));
    }
}
