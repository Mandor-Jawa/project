<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\User;
use App\Services\ProposalService;
use App\Http\Requests\AssignReviewerRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests;

    protected ProposalService $proposalService;

    public function __construct(ProposalService $proposalService)
    {
        $this->proposalService = $proposalService;
    }

    public function index()
    {
        $proposals = Proposal::with('proposer', 'reviewer')->latest()->get();
        return view('admin.dashboard', compact('proposals'));
    }

    public function show(Proposal $proposal)
    {
        $this->authorize('view', $proposal);
        
        $proposal->load('comments.user', 'logs', 'proposer', 'reviewer');
        $reviewers = User::where('role', 'reviewer')->get();
        
        return view('admin.show', compact('proposal', 'reviewers'));
    }

    public function assignReviewer(AssignReviewerRequest $request, Proposal $proposal)
    {
        $this->authorize('view', $proposal); // Or 'assignReviewer' if you want a specific policy rule

        $this->proposalService->assignReviewer($proposal, $request->reviewer_id);

        return redirect()->back()->with('success', 'Reviewer assigned successfully.');
    }

    public function download(Proposal $proposal)
    {
        $this->authorize('download', $proposal);
        
        return $this->proposalService->downloadProposal($proposal);
    }
}
