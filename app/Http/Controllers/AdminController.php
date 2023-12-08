<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        return view('pages.admin');
    }

    public function usersPage() {
        $users = $this->listUsers();
        return view('admin.users', compact('users'));
    }
    public function topicsPage() {
        $topics = $this->listTopics();
        return view('admin.topics', compact('topics'));
    }
    
    public function showUsers() {
        $users = User::all();
        return view('admin.users',['users' => $users]); 
    }

    public function showTopics() {
        $topics = Topic::all();
        return view('admin.topics', ['topics' => $topics]); 
    }
    public function listUsers()
    {
        $adminController = new AdminController();
        return $adminController->showUsers()->getData()['users'];
    }

    public function listTopics()
    {
        $adminController = new AdminController();
        return $adminController->showTopics()->getData()['topics'];
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

    public function blockUser(int $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('home');
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }

        $user->user_blocked = true;

        $user->save();

        return redirect('/admin/users')->with('success', 'User blocked successfully.');
    }


    public function unblockUser(int $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('home');
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.users')->withSuccess('User not found.');
        }

        $user->user_blocked = false;

        $user->save();

        return redirect('/admin/users')->withSuccess('User unlocked successfully.');
    }

}
