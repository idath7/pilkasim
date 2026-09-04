<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Voter;

class VotingController extends Controller
{
    public function index()
    {
        $voterId = session('voter_id');
        if (!$voterId) {
            return redirect()->route('voter.login');
        }

        $voter = Voter::find($voterId);
        if ($voter->has_voted) {
            return view('voting.already_voted', compact('voter'));
        }

        $candidates = Candidate::all();
        return view('voting.index', compact('candidates', 'voter'));
    }

    public function vote(Request $request, $id)
    {
        $voterId = session('voter_id');
        if (!$voterId) {
            return redirect()->route('voter.login')->with('error', 'Sesi Anda telah berakhir.');
        }

        $voter = Voter::find($voterId);
        
        if ($voter->has_voted) {
            return redirect()->route('voting.index')->with('error', 'Anda sudah memberikan suara!');
        }

        $candidate = Candidate::findOrFail($id);
        
        // Process vote
        $candidate->increment('votes');
        
        // Mark voter as has_voted
        $voter->has_voted = true;
        $voter->save();

        // Otomatis logout dan sesi berakhir
        session()->forget(['voter_id', 'has_valid_dynamic_token']);

        return redirect('/')->with('success', 'Terima kasih, ' . $voter->name . '! Suara Anda telah berhasil dicatat.');
    }
}
