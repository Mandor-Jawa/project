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
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('tipe_pengajuan')->nullable()->after('id');
            $table->string('judul_inggris')->nullable()->after('title');
            $table->foreignId('pembimbing_1_id')->nullable()->constrained('users')->onDelete('set null')->after('reviewer_id');
            $table->foreignId('pembimbing_2_id')->nullable()->constrained('users')->onDelete('set null')->after('pembimbing_1_id');
            $table->text('abstract')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign(['pembimbing_1_id']);
            $table->dropForeign(['pembimbing_2_id']);
            $table->dropColumn(['tipe_pengajuan', 'judul_inggris', 'pembimbing_1_id', 'pembimbing_2_id']);
            $table->text('abstract')->nullable(false)->change();
        });
    }
};
