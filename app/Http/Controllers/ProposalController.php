<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\User;
use App\Services\ProposalService;
use App\Http\Requests\StoreProposalRequest;
use App\Http\Requests\UpdateProposalFileRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProposalController extends Controller
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
        $proposals = $user->proposals()->latest()->get();
        return view('proposer.dashboard', compact('proposals'));
    }

    public function create()
    {
        $lecturers = User::where('role', 'reviewer')->get();
        return view('proposer.create', compact('lecturers'));
    }

    public function store(StoreProposalRequest $request)
    {
        $this->proposalService->createProposal($request->validated(), auth()->id());

        return redirect()->route('proposer.dashboard')->with('success', 'Proposal submitted successfully.');
    }

    public function show(Proposal $proposal)
    {
        $this->authorize('view', $proposal);
        
        $proposal->load('comments.user', 'logs');
        
        return view('proposer.show', compact('proposal'));
    }

    public function download(Proposal $proposal)
    {
        $this->authorize('download', $proposal);
        
        return $this->proposalService->downloadProposal($proposal);
    }

    public function updateFile(UpdateProposalFileRequest $request, Proposal $proposal)
    {
        $this->authorize('update', $proposal);

        $this->proposalService->updateProposalFile($proposal, $request->file('pdf_file'));

        return redirect()->route('proposer.proposal.show', $proposal)->with('success', 'Revision submitted successfully.');
    }
}
