<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // We'll let middleware or controller handle it, or we could check if role == proposer
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tipe_pengajuan' => 'required|string',
            'title' => 'required|string|max:255',
            'judul_inggris' => 'required|string|max:255',
            'category' => 'required|string',
            'pembimbing_1_id' => 'required|exists:users,id',
            'pembimbing_2_id' => 'nullable|exists:users,id',
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ];
    }
}
