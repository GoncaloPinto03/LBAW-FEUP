<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Topic;
use App\Models\TopicProposal;
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
    public function topicProposalsPage() {
        $topicproposals = $this->listTopicProposals();
        return view('admin.topicproposals', compact('topicproposals'));
    }
    public function showUsers() {
        $users = User::all();
        return view('admin.users',['users' => $users]); 
    }

    public function showTopics() {
        $topics = Topic::all();
        return view('admin.topics', ['topics' => $topics]); 
    }

    public function showTopicProposals() {
        $topicproposals = TopicProposal::all();
        return view('admin.topicproposals', ['topicproposals' => $topicproposals]); 
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

    public function listTopicProposals()
    {
        $adminController = new AdminController();
        return $adminController->showTopicProposals()->getData()['topicproposals'];
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

    public function acceptTopicProposal($id)
    {
    $topicproposal = TopicProposal::find($id);
    

    // Create a new topic
    $newTopic = new Topic();
    $newTopic->name = $topicproposal->name;
    $newTopic->save();

    // Update the topicproposal record
    $topicproposal->update(['accepted' => true]);

    return redirect('/admin/topicproposals')->with('success', 'Topic proposal accepted successfully.');
    //return response()->json(['success' => 'Topic proposal accepted successfully.']);
    }


    public function denyTopicProposal($id)
    {
    $topicproposal = TopicProposal::find($id);

    // Set the topicproposal record to false
    $topicproposal->update(['accepted' => false]);

    return redirect('/admin/topicproposals')->with('success', 'Topic proposal denied successfully.');
    //return response()->json(['success' => 'Topic proposal denied successfully.']);
    }


}

