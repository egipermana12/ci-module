<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModelTmp extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_data_pegawai_tmp';
    protected $primaryKey       = 'id_pegawai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nm_pegawai','tgl_lahir','jns_kelamin','no_hp','alamat','kd_prov','kd_kab_kota','kd_kec','kd_kel','id_unit_kerja','id_divisi','tgl_bergabung', 'nik','keyfile_flat'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
