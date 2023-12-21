<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainFeaturesController extends Controller
{
    public static function main_features() {
        return view('partials.main_features', ['userClass' => User::class]);
    }
}
