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
use Exception;
use App\Libraries\ImportPegawai;

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
        $this->addJs(base_url() .'vendors/DataTables/JSZip-2.5.0/jszip.min.js');
        $this->addJs(base_url() .'vendors/DataTables/pdfmake-0.2.7/pdfmake.min.js');
        $this->addJs(base_url() .'vendors/DataTables/Buttons-2.3.6/js/buttons.html5.min.js');
        $this->addJs(base_url() .'vendors/DataTables/pdfmake-0.2.7/vfs_fonts.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addStyle( base_url() .'assets/css/page/data-pegawai.css');
        $this->addJs(base_url() .'assets/js/page/data-pegawai.js');
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
                if ($request->id_uni_kerja){
                    $data->where('t_data_pegawai.id_unit_kerja', $request->id_uni_kerja);
                }
                if ($request->id_divisi){
                    $data->where('t_data_pegawai.id_divisi', $request->id_divisi);
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
            $data = [
                'unitKerja' => $this->mUnitKerja->getUnitkerja(),
                'divisKerja' => $this->DivisiKerja(),
            ];
            return view('datapegawai/table', $data);
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
                'foto_pegawai_old' => '',
                'id' => '',
                'nik' => '',
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

    public function edit($id)
    {
        if($this->request->isAJAX()){
            $find = $this->mPegawai->find($id);
            $data = [
                'judul' => 'Update Data Pegawai',
                'nm_pegawai' => $find['nm_pegawai'],
                'tgl_lahir' => $find['tgl_lahir'],
                'jns_kelamin' => $find['jns_kelamin'],
                'no_hp' => $find['no_hp'],
                'alamat' => $find['alamat'],
                'kd_prov' => $find['kd_prov'],
                'kd_kab_kota' => $find['kd_kab_kota'],
                'kd_kec' => $find['kd_kec'],
                'kd_kel' => $find['kd_kel'],
                'id_unit_kerja' => $find['id_unit_kerja'],
                'id_divisi' => $find['id_divisi'],
                'tgl_bergabung' => $find['tgl_bergabung'],
                'foto_pegawai' => $find['foto_pegawai'],
                'foto_pegawai_old' => $find['foto_pegawai'],
                'id' => $find['id_pegawai'],
                'nik' => $find['nik'],
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
                    $res = $this->mKab->select('id_kabkota,nm_kabkota')->where('id_provinsi',$id_provinsi)->get()->getResultArray();
                    echo json_encode($res);
                }   
                if($req == 'getKec'){
                    $id_kabupaten = $this->request->getVar('id_kabupaten');
                    $id_provinsi = $this->request->getVar('id_provinsi');
                    $res = $this->mKec->select('id_kecamatan,nm_kecamatan')->where('id_kabkota',$id_kabupaten)->where('id_prov',$id_provinsi)->get()->getResultArray();
                    echo json_encode($res);
                }
                if($req == 'getKel'){
                    $id_provinsi = $this->request->getVar('id_provinsi');
                    $id_kabupaten = $this->request->getVar('id_kabupaten');
                    $id_kecamatan = $this->request->getVar('id_kecamatan');
                    $res = $this->mKel->select('id_kelurahan,nm_kelurahan')->where('id_provinsi', $id_provinsi)->where('id_kabkota', $id_kabupaten)->where('id_kecamatan',$id_kecamatan)->get()->getResultArray();
                    echo json_encode($res);
                }
            }
        }else{
            return redirect()->to('/');
        }
    }

    private function generatorNIK($data = array())
    {
        $unitKerjaOri = $data['id_unit_kerja'];
        $divisiKerjaOri = $data['id_divisi'];
        $tahun = date('Y', strtotime($data['tahun']));
        $bulan = sprintf("%02d",date('m', strtotime($data['tahun'])));
        $unitkerja = sprintf("%02d",$unitKerjaOri);
        $divisikerja = sprintf("%02d",$divisiKerjaOri);
        $count = $this->mPegawai->where('id_unit_kerja', $unitKerjaOri)
        ->where('id_divisi', $divisiKerjaOri)
        ->countAllResults(false);
        $countZero = sprintf("%03d",$count + 1);
        $result = $tahun . $bulan . $unitkerja . $divisikerja . $countZero;
        return $result;
    }

    public function generateNIK()
    {
        if($this->request->isAJAX()){
            $data = [
                'tahun' => $this->request->getPost('thn_gabung'),
                'id_unit_kerja' => $this->request->getPost('unitkerja'),
                'id_divisi' => $this->request->getPost('divisKerja'),
            ];
            return $this->response->setJSON([
                'success' => true,
                'hasil' => $this->generatorNIK($data)
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    public function create(){
        if($this->request->isAJAX()){
            $formRequest = new PegawaiValidation(); 

            $postData = $this->request->getPost();
            $imgReq = $this->request->getFile('foto_pegawai');
            $postData['foto_pegawai'] = $imgReq;

            $id = $this->request->getPost('id');
            $nik = $this->request->getPost('nik');

            // Validasi data pegawai
            $validationResult = $this->validatePegawaiData($formRequest, $id, $postData, $imgReq);

            if ($validationResult['success']) {
                if($this->request->getPost('id') === '')
                {
                    $saveMessage = $this->savePegawaiData($postData);
                    return $this->response->setJSON([
                        'success' => true,
                        'messages' => $saveMessage
                    ]);
                }else{
                    $updateMessage = $this->updatePegawaiData($postData, $id, $nik);
                    return $this->response->setJSON([
                        'success' => true,
                        'messages' => $updateMessage
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'messages' => $validationResult['errors']
                ]);
            }
        }else{
            return redirect()->to('/');
        }
    }

    private function validatePegawaiData($formRequest, $id ,$postData, $imgReq)
    {
        $rules = $formRequest->getRules($postData, $id);
        $messages = $formRequest->getMessages($postData, $id);
        $imgRules = $formRequest->rulesImage($imgReq);
        $imgMsg = $formRequest->messagesImage($imgReq);

        if (!$this->validate($rules, $messages)) {
            return [
                'success' => false,
                'errors' => $this->validation->getErrors()
            ];
        }

        if (!empty($imgReq) && !$this->validate($imgRules, $imgMsg)) {
            return [
                'success' => false,
                'errors' => $this->validation->getErrors()
            ];
        }

        return ['success' => true];
    }

    private function savePegawaiData($data = array())
    {
        if (key_exists("foto_pegawai", $data)) {
            $image = $data['foto_pegawai'];
            if($image != '')
            {
                $generateName = $image->getRandomName();
                $data['foto_pegawai'] = $generateName;
            }
        }

        if ($this->mPegawai->save($data)) {
            if (!empty($image) && !$image->hasMoved() && $image != '') {
                $image->move(WRITEPATH . '../public/images/pegawai', $generateName);
            }
            return 'Data berhasil disimpan';
        }

        return 'Something wrong';
    }

    private function updatePegawaiData($data = array(), $id, $nik){
        try{
            if (key_exists("foto_pegawai", $data)) {
                $image = $data['foto_pegawai'];
                $imageold = $data['foto_pegawai_old'];
                if($image != '')
                {
                    $generateName = $image->getRandomName();
                    $data['foto_pegawai'] = $generateName;
                    $imagenya = WRITEPATH . '../public/images/pegawai/' . $imageold;
                    if(!empty($imagenya) && file_exists($imagenya) && $imageold != '' && $imageold != NULL){
                        unlink($imagenya);
                    }
                }else{
                    $data['foto_pegawai'] = $data['foto_pegawai_old'];
                }
            }

            if ($this->mPegawai->update(['id'=>$id, 'nik' => $nik],$data)) {
                if (!empty($image) && !$image->hasMoved() && $image != '') {
                    $image->move(WRITEPATH . '../public/images/pegawai', $generateName);
                }
                return 'Data berhasil diupdate';
            }

            return 'Something wrong';

        }catch(Exception $e){
            throw new Exception('Something wrong');
        }
    }

    public function destroy()
    {
        if ($this->request->isAJAX()){
            $ids = $this->request->getPost('id');
            $id = explode(",", $ids);
            $message = "";
            for ($i = 0; $i < sizeof($id); $i++) {
                $file = $this->mPegawai->find($id[$i]);
                $gambar = $file['foto_pegawai'];
                $imagenya = WRITEPATH . '../public/images/pegawai/' . $gambar;
                if(!empty($imagenya) && file_exists($imagenya) && $gambar != '' && $gambar != NULL){
                    unlink($imagenya);
                }   
                $this->mPegawai->delete($id[$i]);
                $message = "Data berhasil dihapus";
            }
            return $this->response->setJSON([
                'err' => false,
                'messages' => $message
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    public function FormImport()
    {
        if($this->request->isAJAX()){
            $data = [
                'judul' => 'Import Data Pegawai'
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('datapegawai/formImport', $data)
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    public function importAction()
    {
        if($this->request->isAJAX()){
            $file = $this->request->getFile('file_excel_pegawai');
            $filename = date('YmdHis');
            $import = new ImportPegawai();
            $impExec = $import->importExcel($file,$filename);
            return $this->response->setJSON([
                'err' => false,
                'messages' => $impExec
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    //batas
}
