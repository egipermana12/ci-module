<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\UnitKerjaModel;
use App\Models\DivisiModel;
use App\Models\ProvinsiModel;
use App\Models\KabupatenModel;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use \Hermawan\DataTables\DataTable;
use App\Validation\PegawaiValidation;


class Pegawai extends BaseController
{
    public $validation;
    public $mPegawai;
    public $mUnitKerja;
    public $mDivisi;
    public $mProvinsi;
    public $mKab;
    public $mKec;
    public $mKel;

    public function __construct()
    {
        $this->data['site_title'] = 'Data Pegawai';
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addStyle( base_url() .'assets/css/page/data-pegawai.css');
        $this->addJsBawah(base_url() .'assets/js/page/data-pegawai.js');
        $this->validation =  \Config\Services::validation();
        $this->mPegawai = new PegawaiModel;
        $this->mUnitKerja = new UnitKerjaModel;
        $this->mDivisi = new DivisiModel;
        $this->mProvinsi = new ProvinsiModel;
        $this->mKab = new KabupatenModel;
        $this->mKec = new KecamatanModel;
        $this->mKel = new KelurahanModel;
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

    private function DivisiKerja()
    {
        return $this->mDivisi->select('id_divisi_kerja,nm_divisi')->get()->getResultArray();
    }

    private function Provinsi()
    {
        return $this->mProvinsi->select('id_provinsi,nm_provinsi')->get()->getResultArray();
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
                'unitKerja' => $this->mUnitKerja->getUnitkerja(),
                'divisKerja' => $this->DivisiKerja(),
                'prov' => $this->Provinsi()
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('datapegawai/form', $data)
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    public function getWilayah()
    {
        if($this->request->isAJAX()){
            if($this->request->getVar('getWilayah')){
                $req = $this->request->getVar('getWilayah');
                if($req == 'getKabKota'){
                    $id_provinsi = $this->request->getVar('id_provinsi');
                    $res = $this->mKab->select('id_kabkota,nm_kabkota')->where('id_provinsi',$id_provinsi)->findAll();
                    echo json_encode($res);
                }   
                if($req == 'getKec'){
                    $id_kabupaten = $this->request->getVar('id_kabupaten');
                    $id_provinsi = $this->request->getVar('id_provinsi');
                    $res = $this->mKec->select('id_kecamatan,nm_kecamatan')->where('id_kabkota',$id_kabupaten)->where('id_prov',$id_provinsi)->findAll();
                    echo json_encode($res);
                }
                if($req == 'getKel'){
                    $id_provinsi = $this->request->getVar('id_provinsi');
                    $id_kabupaten = $this->request->getVar('id_kabupaten');
                    $id_kecamatan = $this->request->getVar('id_kecamatan');
                    $res = $this->mKel->select('id_kelurahan,nm_kelurahan')->where('id_provinsi', $id_provinsi)->where('id_kabkota', $id_kabupaten)->where('id_kecamatan',$id_kecamatan)->findAll();
                    echo json_encode($res);
                }
            }
        }else{
            return redirect()->to('/');
        }
    }

    public function create(){
        if($this->request->isAJAX()){
            $formRequest = new PegawaiValidation(); 
            /**
             * get post input
             * @var [type]
             */
            $rules = $formRequest->getRules($this->request->getPost());
            $messages = $formRequest->getMessages($this->request->getPost());

            /**
             * get post image
             */
            $imgReq = $this->request->getFile('foto_pegawai');
            $imgRules = $formRequest->rulesImage($imgReq);
            $imgMsg = $formRequest->messagesImage($imgReq);

            if(!$this->validate($rules, $messages)){
                return $this->response->setJSON([
                    'err' => true,
                    'messages' => $this->validation->getErrors()
                ]);
            }
            if(!empty($imgReq)){
                if(!$this->validate($imgRules, $imgMsg)){
                    return $this->response->setJSON([
                        'err' => true,
                        'messages' => $this->validation->getErrors()
                    ]);
                }
            }
            return $this->response->setJSON([
                'err' => false,
                'messages' => 'Sukses'
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    //batas
}