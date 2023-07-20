<?php

namespace App\Validation;

class PegawaiValidation
{
    public function getRules($post): array
    {
        return [
            'nm_pegawai' => [
                'rules' => 'required',
            ],
            'tgl_lahir' => [
                'rules' => 'required|valid_date[Y-m-d]'
            ]
        ];
    }

    public function getMessages($post): array 
    {
        return [
            'nm_pegawai' => [
                'required' => 'Nama pegawai tidak boleh kosong'
            ],
            'tgl_lahir' => [
                'required' => 'Tanggal lahir harus diisi',
                'valid_date' => 'Format tanggal harus YYYY-MM-DD'
            ],
        ];
    }
}
