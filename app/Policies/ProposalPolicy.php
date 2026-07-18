<?php

namespace App\Policies;

use App\Models\Proposal;
use App\Models\User;

class ProposalPolicy
{
    /**
     * Determine whether the user can view the proposal.
     */
    public function view(User $user, Proposal $proposal): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'proposer') {
            return $user->id === $proposal->proposer_id;
        }

        if ($user->role === 'reviewer') {
            return $user->id === $proposal->reviewer_id;
        }

        return false;
    }

    /**
     * Determine whether the user can update the proposal (upload revision).
     */
    public function update(User $user, Proposal $proposal): bool
    {
        return $user->role === 'proposer' && 
               $user->id === $proposal->proposer_id && 
               in_array($proposal->status, ['revision_required', 'rejected']);
    }

    /**
     * Determine whether the user can review the proposal.
     */
    public function review(User $user, Proposal $proposal): bool
    {
        return $user->role === 'reviewer' && $user->id === $proposal->reviewer_id;
    }

    /**
     * Determine whether the user can download the proposal file.
     */
    public function download(User $user, Proposal $proposal): bool
    {
        return $this->view($user, $proposal);
    }
}
