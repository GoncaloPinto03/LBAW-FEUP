<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Admin;
use App\Models\Photo;


class UserController extends Controller
{
    function showUsersList() {
        $users = User::all();
        return view('pages.admin', ['users' => $users]); 
    }

    public function index(int $id) 
    {   
        $user = User::find($id);

        if(Auth::guard('admin')->check()) {
            return view('profile', ['user' => $user]);    
        }
        if(!Auth::check()) {
            return redirect()->intended('/home');
        }

        return view('profile', ['user' => $user]);
    }

    public function edit($id)
    {
        //$user = Auth::User();
        //$this->authorize('editUser', Auth::user());
        $user = User::find($id);

        // Check if the authenticated user is an admin
        if (Auth::guard('admin')->check()) {
            // If the authenticated user is an admin, pass the user information for editing
            return view('edit_profile', ['user' => $user]);
        } elseif (Auth::user()->user_id == $user->user_id) {
            // If the authenticated user is the owner of the profile, allow editing
            return view('edit_profile', ['user' => $user]);
        }
        // If the authenticated user is neither an admin nor the owner of the profile, redirect to home
        return redirect()->intended('/home');
    }

    public function update(Request $request, $id)

    {
        $user = User::find($id);
        //$user = Auth::user();
        //$this->authorize('editUser', Auth::user());
        $request->validate([
            'name' => 'unique:users,name,'.$user->user_id.',user_id|max:255',
            'email' => 'email|unique:users,email,'.$user->user_id.',user_id|max:255'
        ]);
        if($request->file('image')){
            if( !in_array(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION),['jpg','jpeg','png'])) {
                return redirect('profile/edit');
            }
            $request->validate([
                'image' =>  'mimes:png,jpeg,jpg',
            ]);
            PhotoController::update($user->user_id, 'profile', $request);
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect('profile/'.$user->user_id);
    }

    public function showArticles(int $id)
    {
        $user = User::find($id);

        $articles = $user->articles;

        return view('user-articles', compact('user', 'articles'));
    }


    public function deleteUser($id)
    {
        $user = User::find($id);

        if (Auth::guard('admin')->check() || Auth::user()->user_id == $user->user_id) {
            $user->delete();

            return redirect('/home')->with('success', 'User deleted successfully');
        }

        return redirect('/home')->with('error', 'Unauthorized to delete user');
    }


  

    public function destroy_user($id){
        $user = Auth::user();
        $user->name = "Anonymous";
        $user->email = "anonymous" . $user->user_id . "@example.com";
        $user->password = Hash::make(Str::random(40)); 
        $user->save();
        Auth::logout();
        return redirect()->route('home');
    }

    public function follow(Request $request)
    {
        $userToFollowId = $request->input('user_id');
        $userToFollow = User::find($userToFollowId);

        if (!$userToFollow) {
            // Usuário a ser seguido não encontrado
            return redirect()->back()->with('error', 'User not found');
        }

        // Verifique se o usuário já não está seguindo o outro usuário
        if (!Auth::user()->isFollowing($userToFollowId)) {
            // Adicione o relacionamento de seguidor
            Auth::user()->following()->attach($userToFollowId);

            // Incrementa o contador de seguidores do usuário seguido
            $userToFollow->increment('number_followers');

            return redirect()->back()->with('success', 'You are now following ' . $userToFollow->name);
        }

        return redirect()->back()->with('error', 'You are already following ' . $userToFollow->name);
    }

    public function unfollow(Request $request)
    {
        $userToUnfollowId = $request->input('user_id');
        $userToUnfollow = User::find($userToUnfollowId);

        if (!$userToUnfollow) {
            // Usuário a ser deixado de seguir não encontrado
            return redirect()->back()->with('error', 'User not found');
        }

        // Verifique se o usuário está seguindo o outro usuário
        if (Auth::user()->isFollowing($userToUnfollowId)) {
            // Remova o relacionamento de seguidor
            Auth::user()->following()->detach($userToUnfollowId);

            // Decrementa o contador de seguidores do usuário deixado de seguir
            $userToUnfollow->decrement('number_followers');

            return redirect()->back()->with('success', 'You have unfollowed ' . $userToUnfollow->name);
        }

        return redirect()->back()->with('error', 'You are not following ' . $userToUnfollow->name);
    }

    
}

