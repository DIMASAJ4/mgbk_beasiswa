<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeasiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('Admin');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama_beasiswa' => ['required', 'string', 'max:255'],
            'kampus_mitra_id' => ['required', 'exists:kampus_mitras,id'],
            'jenis' => ['required', 'in:full_funding,partial_funding,akomodasi'],
            'deskripsi' => ['required', 'string'],
            'persyaratan' => ['required', 'array', 'min:1'],
            'persyaratan.*' => ['required', 'string', 'max:255'],
            'kuota' => ['required', 'integer', 'min:1'],
            'deadline' => ['required', 'date', 'after_or_equal:today'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status' => ['required', 'in:aktif,draft,tutup'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_beasiswa' => 'Nama Beasiswa',
            'kampus_mitra_id' => 'Kampus Mitra',
            'jenis' => 'Jenis Beasiswa',
            'deskripsi' => 'Deskripsi Beasiswa',
            'persyaratan' => 'Persyaratan',
            'persyaratan.*' => 'Item Persyaratan',
            'kuota' => 'Kuota Beasiswa',
            'deadline' => 'Batas Akhir (Deadline)',
            'thumbnail' => 'Gambar/Thumbnail',
            'status' => 'Status',
        ];
    }
}
