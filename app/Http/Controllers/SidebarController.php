<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class SidebarController extends Controller
{
    //
    function showSidebar() {
        $topics = Topic::all();
        dd($topics);
        return view('partials.sidebar', ['topics' => $topics]); 
    }
}
