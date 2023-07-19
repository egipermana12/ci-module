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
        ];
    }

    public function getMessages($post): array 
    {
        return [
            'nm_pegawai' => [
                'required' => 'Nama pegawai tidak boleh kosong'
            ]
        ];
    }
}
