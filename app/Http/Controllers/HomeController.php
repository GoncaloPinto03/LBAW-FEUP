<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $topics = $this->getSidebarData();

        return view('home', compact('topics'));
    }

    private function getSidebarData()
    {
        $sidebarController = new SidebarController();
        return $sidebarController->showSidebar()->getData()['topics'];
    }


}