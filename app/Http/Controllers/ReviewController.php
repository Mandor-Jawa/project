<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Services\ProposalService;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    protected ProposalService $proposalService;

    public function __construct(ProposalService $proposalService)
    {
        $this->proposalService = $proposalService;
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $proposals = $user->assignedProposals()->latest()->get();
        return view('reviewer.dashboard', compact('proposals'));
    }

    public function show(Proposal $proposal)
    {
        $this->authorize('review', $proposal);
        
        $proposal->load('comments.user', 'logs', 'proposer');
        
        return view('reviewer.show', compact('proposal'));
    }

    public function storeReview(StoreReviewRequest $request, Proposal $proposal)
    {
        $this->authorize('review', $proposal);

        $this->proposalService->submitReview(
            $proposal, 
            $request->status, 
            $request->comment, 
            auth()->id()
        );

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    public function download(Proposal $proposal)
    {
        $this->authorize('download', $proposal);
        
        return $this->proposalService->downloadProposal($proposal);
    }
}
