<?php

namespace App\Validation;
use App\Models\UnitKerjaModel;

class PegawaiValidation
{
    public function getRules($post): array
    {
        $unitkerja = new UnitKerjaModel;
        $list = $unitkerja->mapUnitkerja();
        return [
            'nm_pegawai' => [
                'rules' => 'required',
            ],
            'tgl_lahir' => [
                'rules' => 'required|valid_date[Y-m-d]'
            ],
            'tgl_bergabung' => [
                'rules' => 'required|valid_date[Y-m-d]'
            ],
            'jns_kelamin' => [
                'rules' => 'required|in_list[L,P]'
            ],
            'id_unit_kerja' => [
                'rules' => 'required|in_list['.$list.']'
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
            'tgl_bergabung' => [
                'required' => 'Tanggal lahir harus diisi',
                'valid_date' => 'Format tanggal harus YYYY-MM-DD'
            ],
            'jns_kelamin' => [
                'required' => 'Jenis kelamin harus dipilih',
                'in_list' => 'Harus pilih L atau P'
            ],
            'id_unit_kerja' => [
                'required' => 'Unit kerja harus dipilih',
                'in_list' => 'Unit kerja yang dipilih tidak sesuai'
            ]
        ];
    }

    public function rulesImage($img): array
    {
        return [
            'foto_pegawai' => [
                'rules' => 'is_image[foto_pegawai]|mime_in[foto_pegawai,image/jpg,image/jpeg,image/png]|max_size[foto_pegawai,2048]'
            ]
        ];
    }

    public function messagesImage($img): array
    {
        return [
            'foto_pegawai' => [
                'is_image' => 'Harus berupa gambar',
                'mime_in' => 'Dalam format jpg, jpeg, png',
                'max_size' => 'Maksimal 200MB'
            ]
        ];
    }
}
