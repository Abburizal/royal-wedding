<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeddingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // handled by route middleware
    }

    public function rules(): array
    {
        return [
            'client_id'        => 'required|exists:users,id',
            'planner_id'       => 'nullable|exists:users,id',
            'package_id'       => 'required|exists:packages,id',
            'groom_name'       => 'required|string|max:100',
            'bride_name'       => 'required|string|max:100',
            'wedding_date'     => 'required|date|after:today',
            'venue_name'       => 'nullable|string|max:200',
            'venue_address'    => 'nullable|string',
            'venue_city'       => 'nullable|string|max:100',
            'estimated_guests' => 'nullable|integer|min:0',
            'total_price'      => 'required|numeric|min:0',
            'special_notes'    => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required'    => 'Klien harus dipilih.',
            'package_id.required'   => 'Paket harus dipilih.',
            'groom_name.required'   => 'Nama pengantin pria wajib diisi.',
            'bride_name.required'   => 'Nama pengantin wanita wajib diisi.',
            'wedding_date.required' => 'Tanggal pernikahan wajib diisi.',
            'wedding_date.after'    => 'Tanggal pernikahan harus di masa mendatang.',
            'total_price.required'  => 'Total harga wajib diisi.',
        ];
    }
}
