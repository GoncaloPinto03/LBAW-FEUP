<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public static function about() {
        return view('partials.about', ['userClass' => User::class]);
    }
}
