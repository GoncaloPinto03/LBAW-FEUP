<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopicProposal;

class TopicController extends Controller
{
    public function showProposalForm()
    {
        return view('propose_topic');
    }

    public function submitProposal(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|unique:topicproposal,name',
        ]);

        // Create a new Topic Proposal  
        $topicProposal = new TopicProposal();
        $topicProposal->name = $request->input('name');
        $topicProposal->user_id = auth()->user()->user_id;
        $topicProposal->date = now();
        $topicProposal->save();

        return redirect('/home')->with('success', 'Topic proposed successfully.');
    }
}
