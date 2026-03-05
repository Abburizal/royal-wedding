<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeddingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'           => 'required|in:inquired,confirmed,in_progress,completed,cancelled',
            'planner_id'       => 'nullable|exists:users,id',
            'groom_name'       => 'required|string|max:100',
            'bride_name'       => 'required|string|max:100',
            'wedding_date'     => 'required|date',
            'venue_name'       => 'nullable|string|max:200',
            'venue_address'    => 'nullable|string',
            'venue_city'       => 'nullable|string|max:100',
            'special_notes'    => 'nullable|string',
            'estimated_guests' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'groom_name.required'   => 'Nama pengantin pria wajib diisi.',
            'bride_name.required'   => 'Nama pengantin wanita wajib diisi.',
            'wedding_date.required' => 'Tanggal pernikahan wajib diisi.',
            'status.in'             => 'Status tidak valid.',
        ];
    }
}
