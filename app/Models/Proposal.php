<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['proposer_id', 'reviewer_id', 'title', 'judul_inggris', 'tipe_pengajuan', 'pembimbing_1_id', 'pembimbing_2_id', 'abstract', 'category', 'team_members', 'file_path', 'status', 'submission_deadline', 'review_deadline'])]
class Proposal extends Model
{
    /** @use HasFactory<\Database\Factories\ProposalFactory> */
    use HasFactory;

    public function proposer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'proposer_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ProposalComment::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ProposalLog::class);
    }
}
