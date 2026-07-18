<?php

namespace App\Services;

use App\Models\Proposal;
use Illuminate\Support\Facades\Storage;

class ProposalService
{
    /**
     * Create a new proposal and handle the file upload.
     */
    public function createProposal(array $data, int $userId): Proposal
    {
        $filePath = $data['pdf_file']->store('proposals', 'local');

        $proposal = Proposal::create([
            'proposer_id' => $userId,
            'tipe_pengajuan' => $data['tipe_pengajuan'],
            'title' => $data['title'],
            'judul_inggris' => $data['judul_inggris'],
            'category' => $data['category'],
            'pembimbing_1_id' => $data['pembimbing_1_id'],
            'pembimbing_2_id' => $data['pembimbing_2_id'] ?? null,
            'file_path' => $filePath,
            'status' => 'pending_review',
        ]);

        $proposal->logs()->create(['action' => 'Proposal created and PDF uploaded.']);

        return $proposal;
    }

    /**
     * Update an existing proposal's file.
     */
    public function updateProposalFile(Proposal $proposal, $file): Proposal
    {
        $filePath = $file->store('proposals', 'local');

        // Delete old file if exists
        if ($proposal->file_path && Storage::disk('local')->exists($proposal->file_path)) {
            Storage::disk('local')->delete($proposal->file_path);
        }

        $proposal->update([
            'file_path' => $filePath,
            'status' => 'revision_submitted',
        ]);

        $proposal->logs()->create(['action' => 'Proposal revision submitted and new PDF uploaded.']);

        return $proposal;
    }

    /**
     * Assign a reviewer to a proposal.
     */
    public function assignReviewer(Proposal $proposal, int $reviewerId): void
    {
        $proposal->update(['reviewer_id' => $reviewerId]);
        $proposal->logs()->create(['action' => "Reviewer assigned by admin."]);
    }

    /**
     * Submit a review for a proposal.
     */
    public function submitReview(Proposal $proposal, string $status, ?string $comment, int $reviewerId): void
    {
        $proposal->update(['status' => $status]);

        if ($comment) {
            $proposal->comments()->create([
                'user_id' => $reviewerId,
                'comment' => $comment,
            ]);
        }

        $proposal->logs()->create(['action' => "Status updated to {$status} by reviewer."]);
    }

    /**
     * Get the file download response for a proposal.
     */
    public function downloadProposal(Proposal $proposal)
    {
        if (!Storage::disk('local')->exists($proposal->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download($proposal->file_path);
    }
}
