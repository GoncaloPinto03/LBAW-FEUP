<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public static function faqs() {
        return view('partials.faqs', ['userClass' => User::class]);
    }
}
