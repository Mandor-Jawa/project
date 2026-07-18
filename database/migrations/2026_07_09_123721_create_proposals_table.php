<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->text('abstract');
            $table->string('category');
            $table->text('team_members')->nullable();
            $table->string('file_path')->nullable();
            $table->string('status')->default('draft'); // draft, pending_review, under_review, revision_required, approved, rejected
            $table->timestamp('submission_deadline')->nullable();
            $table->timestamp('review_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
