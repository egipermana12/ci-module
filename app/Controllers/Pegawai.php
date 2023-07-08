<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use \Hermawan\DataTables\DataTable;


class Pegawai extends BaseController
{
    public $validation;
    public $mPegawai;

    public function __construct()
    {
        $this->data['site_title'] = 'Data Pegawai';
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addStyle( base_url() .'assets/css/page/data-pegawai.css');
        $this->addJsBawah(base_url() .'assets/js/page/data-pegawai.js');
        $this->validation =  \Config\Services::validation();
        $this->mPegawai = new PegawaiModel;
    }

    public function index()
    {
        return $this->getView('datapegawai/index', $this->data);
    }

    public function fetchData()
    {
        if($this->request->isAJAX()){
            $data = $this->mPegawai->table('t_data_pegawai')->select('t_data_pegawai.id_pegawai,t_data_pegawai.nm_pegawai,t_data_pegawai.tgl_lahir,t_data_pegawai.jns_kelamin,t_data_pegawai.no_hp,t_data_pegawai.alamat as alamat,t_data_pegawai.kd_prov,t_data_pegawai.kd_kab_kota,t_data_pegawai.kd_kec,t_data_pegawai.kd_kel,t_data_pegawai.id_unit_kerja,t_data_pegawai.id_divisi,t_data_pegawai.tgl_bergabung,t_data_pegawai.foto_pegawai,b.nm_unit_kerja, c.nm_divisi')
            ->join('t_unit_kerja b', 'b.id_unit_kerja = t_data_pegawai.id_unit_kerja')
            ->join('t_divisi_kerja c', 'c.id_divisi_kerja = t_data_pegawai.id_divisi');
            return DataTable::of($data)
            ->filter(function($data, $request){
                if ($request->id_label){
                    $data->where('t_data_pegawai.id_unit_kerja', $request->id_label);
                }
            })
            ->add('aksi', function($row){
                return '<input class="form-check-input cb-custom pegawaicb" name="pegawaicb" type="checkbox" value="'.$row->id_pegawai.'">';
            })
            ->addNumbering('no')
            ->hide('id_pegawai')
            ->toJson(true);
        }else{
            return redirect()->to('/');
        }
    }

    public function view()
    {
        if($this->request->isAJAX()){
            return view('datapegawai/table');
        }else{
            return redirect()->to('/');
        }
    }

    public function new()
    {
        if($this->request->isAJAX()){
            $data = [
                'judul' => 'Tambah Data Pegawai',
                'nm_pegawai' => '',
                'tgl_lahir' => '',
                'jns_kelamin' => '',
                'no_hp' => '',
                'alamat' => '',
                'kd_prov' => '',
                'kd_kab_kota' => '',
                'kd_kec' => '',
                'kd_kel' => '',
                'id_unit_kerja' => '',
                'id_divisi' => '',
                'tgl_bergabung' => '',
                'foto_pegawai' => '',
                'id' => '',
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('datapegawai/form', $data)
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    //batas
}
