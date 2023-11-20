<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index() 
    {   
        $users = $this->getUsersList();

        return view('pages.admin', compact('users'));
    }

    function showUsers() {
        $users = User::all();
        return view('pages.admin', ['users' => $users]); 
    }
    private function getUsersList()
    {
        $adminController = new AdminController();
        return $adminController->showUsers()->getData()['users'];
    }

    public function show_profile(int $id)
    {
        if(!Auth::guard('admin')->check())
        {
            return redirect()->route('home');
        }

        $admin = Admin::find($id);

        return view('profile_admin', ['admin' => $admin]);

    }

    public function edit_profile() {
        $admin = Auth::guard('admin')->user();

        return view('edit_admin_profile', compact('admin'));
    }

    public function update_profile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'unique:admin,name,'.$admin->admin_id.',admin_id|max:255',
            'email' => 'email|unique:users,email|unique:admin,email,'.$admin->admin_id.',admin_id|max:255'
        ]);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->save();

        return redirect('profile_admin/'.$admin->admin_id);
    }

    public function search_user(Request $request)
    {
        $search_text = $request->input('query');
        $users = User::where('name', 'ilike', $search_text)->get();

        return view('pages.admin', compact('users'));
    }
}
