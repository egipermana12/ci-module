<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;
use App\Models\UnitKerjaModel;
use \Hermawan\DataTables\DataTable;

class UnitKerja extends BaseController
{
    public $mUnikerja;
    public $validation;
    public function __construct()
    {
        $this->data['site_title'] = 'Unit Kerja';
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addStyle( base_url() .'assets/css/page/unit-kerja.css');
        $this->addJsBawah(base_url() .'assets/js/page/unit-kerja.js');
        $this->validation =  \Config\Services::validation();
        $this->mUnikerja = new UnitKerjaModel();
    }
    public function index()
    {
        return view('setting/unitkerja/index', $this->data);
    }

    public function fetchData()
    {
        if($this->request->isAJAX()){
            $data = $this->mUnikerja->select('id_unit_kerja,nm_unit_kerja,alamat,koordinat_lokasi,jarak_toleran');
            return DataTable::of($data)
            ->add('aksi', function($row){
                return '<input class="form-check-input cb-custom unitkerjacb" name="unitkerjacb" type="checkbox" value="'.$row->id_unit_kerja.'">';
            })
            ->addNumbering('no')
            ->hide('id_unit_kerja')
            ->toJson(true);
        }else{
            return redirect()->to('/');
        }
    }

    function new()
    {
        if ($this->request->isAJAX())
        {
            $data = [
                'judul' => 'Tambah Unit Keja',
                'nm_unit_kerja' => '',
                'jarak_toleran' => '',
                'koordinat_lokasi' => '',
                'koordinat_bidang' => '',
                'alamat' => '',
                'gambar' => '',
                'gambarold' => '',
                'id' => '',
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/unitkerja/form', $data)
            ]); 
        }else{
            return redirect()->to('/');
        }
    }

    public function edit($id){
        if ($this->request->isAJAX()){
            $find = $this->mUnikerja->find($id); //ganti find
            $data = [
                'judul' => 'Update Unit Kerja',
                'nm_unit_kerja' => $find['nm_unit_kerja'],
                'jarak_toleran' => $find['jarak_toleran'],
                'koordinat_lokasi' => $find['koordinat_lokasi'],
                'koordinat_bidang' => $find['koordinat_bidang'],
                'alamat' => $find['alamat'],
                'gambar' => $find['gambar'],
                'gambarold' => $find['gambar'],
                'id' => $find['id_unit_kerja'],
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/unitkerja/form', $data)
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    function create()
    {
        if ($this->request->isAJAX()){
            $id = $this->request->getPost('id');
            $gambarold = $this->request->getPost('gambarold');
            $data = [
                'nm_unit_kerja' => $this->request->getPost('nm_unit_kerja'),
                'jarak_toleran' => $this->request->getPost('jarak_toleran'),
                'koordinat_lokasi' => $this->request->getPost('koordinat_lokasi'),
                'koordinat_bidang' => $this->request->getPost('koordinat_bidang'),
                'alamat' => $this->request->getPost('alamat'),
                'gambarfile' => $this->request->getFile('gambarfile'),
                'gambarold' => $gambarold,
            ];
            $rulesImage = [];
            if(empty($gambarold)){
                $rulesImage = [
                    'uploaded[gambarfile]',
                    'is_image[gambarfile]',
                    'mime_in[gambarfile,image/jpg,image/jpeg,image/png]',
                    'max_size[gambarfile,2048]'
                ];
            }
            $rules = 
            [
                'nm_unit_kerja' => 'required',
                'jarak_toleran' => 'required|numeric',
                'koordinat_lokasi' => 'required',
                'gambarfile' => $rulesImage
            ];
            $messages = 
            [
                'nm_unit_kerja' => [
                    'required' => 'Nama unit kerja tidak boleh kosong'
                ],
                'jarak_toleran' => [
                    'required' => 'Jarak tidak boleh kosong',
                    'numeric' => 'Harus berupa angka'
                ],
                'koordinat_lokasi' => [
                    'required' => 'koordinat_lokasi tidak boleh kosong'
                ],
                'gambarfile' => [
                    'uploaded' => 'Harus ada gambar yang diupload',
                    'is_image' => 'Harus berupa gambar',
                    'mime_in' => 'File yang diijinkan berupa png,jpg, jpeg',
                    'max_size' => 'File maximal 2000kb'
                ]
            ];
            if(!$this->validate($rules, $messages)){
                return $this->response->setJSON([
                    'err' => true,
                    'messages' => $this->validation->getErrors()
                ]);
            }else{
                if($id === ''){
                    $save = $this->save($data);
                    return $this->response->setJSON([
                        'err' => false,
                        'messages' => $save
                    ]);
                }else{
                    $update = $this->update($id, $data);
                    return $this->response->setJSON([
                        'err' => false,
                        'messages' => $update
                    ]);
                }
            }
        }else{
            return redirect()->to('/');
        }
    }

    private function save($data = [])
    {
        $message = 'Something wrong';
        $image = $data['gambarfile'];
        $generateName = $image->getRandomName();
        $data['gambar'] = $generateName; 
        $save = $this->mUnikerja->save($data);
        if($save)
        {
            if (!empty($image) && !$image->hasMoved()) {
                $image->move(WRITEPATH . '../public/images/unitkerja', $generateName);
            }
            $message = 'Data berhasil disimpan';
            return $message;
        }
        return $message;
    }

    private function update($id, $data = [])
    {
        $message = 'Something wrong';
        $image = $data['gambarfile'];
        $imageold = $data['gambarold'];
        if($image->isValid() && !$image->hasMoved()){
            $imagenya = WRITEPATH . '../public/images/unitkerja/' . $imageold;
            if(!empty($imagenya) && file_exists($imagenya) && $imageold != '' && $imageold != NULL){
                unlink($imagenya);
            }
                $generateName = $image->getRandomName();
                $image->move(WRITEPATH . '../public/images/unitkerja', $generateName);
                $data['gambar'] = $generateName;
        }
        $save = $this->mUnikerja->update($id, $data);
        if($save)
        {
            $message = 'Data berhasil diupdate';
            return $message;
        }
        return $message;
    }

    public function destroy()
    {
        if ($this->request->isAJAX()){
            $ids = $this->request->getPost('id');
            $id = explode(",", $ids);
            $message = "";
            for ($i = 0; $i < sizeof($id); $i++) {
                $file = $this->mUnikerja->find($id[$i]);
                $gambar = $file['gambar'];
                $imagenya = WRITEPATH . '../public/images/unitkerja/' . $gambar;
                if(!empty($imagenya) && file_exists($imagenya) && $gambar != '' && $gambar != NULL){
                    unlink($imagenya);
                }   
                $this->mUnikerja->delete($id[$i]);
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

//batas    
}
