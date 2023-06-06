<?php

namespace App\Models;

use CodeIgniter\Model;

class KalenderKerjaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kalender_kerja';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kalender_label', 'tgl_mulai_kegiatan', 'tg_selesai_kegiatan', 'nm_kegiatan'
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

    public function generateTglWarna($tahun)
    {
        $builder = $this->db->table('kalender_kerja');
        $builder->select('kalender_kerja.tgl_mulai_kegiatan, kalender_kerja.tgl_selesai_kegiatan,kalender_kerja.nm_kegiatan, kalender_label.warna');
        $builder->join('kalender_label', 'kalender_kerja.id_kalender_label=kalender_label.id');
        $builder->where('year(tgl_mulai_kegiatan)', $tahun);
        $builder->orderBy('tgl_mulai_kegiatan', 'ASC');
        $query = $builder->get()->getResultArray();
        // $result = array_column($query, 'tgl_mulai_kegiatan');
        return $query;
    }
}
