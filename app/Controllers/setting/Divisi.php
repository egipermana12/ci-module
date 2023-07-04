<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;
use App\Models\DivisiModel;
use \Hermawan\DataTables\DataTable;

class Divisi extends BaseController
{
    public $validation;
    public $mDivisi;
    public function __construct()
    {
        $this->data['site_title'] = 'Divisi Kerja';
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addStyle( base_url() .'assets/css/page/unit-kerja.css');
        $this->addJsBawah(base_url() .'assets/js/page/divisi-kerja.js');
        $this->validation =  \Config\Services::validation();
        $this->mDivisi = new DivisiModel;
    }
    public function index()
    {
        return $this->getView('setting/divisikerja/index', $this->data);
    }

    public function fetchData()
    {
        if($this->request->isAJAX()){
            $data = $this->mDivisi->select('id_divisi_kerja,nm_divisi, standar_gaji');
            return DataTable::of($data)
            ->add('aksi', function($row){
                return '<input class="form-check-input cb-custom divisicb" name="divisicb" type="checkbox" value="'.$row->id_divisi_kerja.'">';
            })
            ->format('standar_gaji', function($value){
                return formatUang($value, true);
            })
            ->addNumbering('no')
            ->hide('id_divisi_kerja')
            ->toJson(true);
        }else{
            return redirect()->to('/');
        }
    }

    public function new()
    {
        if($this->request->isAJAX()){
            $data = [
                'judul' => 'Tambah Divisi Kerja',
                'nm_divisi' => '',
                'standar_gaji' => '',
                'id' => '',
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/divisikerja/form', $data)
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    public function edit($id)
    {
        if($this->request->isAJAX()){
            $find = $this->mDivisi->find($id); //ganti find
            $data = [
                'judul' => 'Update Divisi Kerja',
                'nm_divisi' => $find['nm_divisi'],
                'standar_gaji' => $find['standar_gaji'],
                'id' => $find['id_divisi_kerja'],
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/divisikerja/form', $data)
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    public function create()
    {
         if ($this->request->isAJAX()){
            $id = $this->request->getPost('id');
            $data = [
                'nm_divisi' => $this->request->getPost('nm_divisi'),
                'standar_gaji' => $this->request->getPost('standar_gaji'),
            ];
            $rules = 
            [
                'nm_divisi' => 'required',
                'standar_gaji' => 'required|numeric'
            ];
            $messages = 
            [
                'nm_divisi' => [
                    'required' => 'Nama divisi kerja tidak boleh kosong'
                ],
                'standar_gaji' => [
                    'required' => 'Standar Gaji boleh kosong',
                    'numeric' => 'Harus berupa angka'
                ],
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
        $save = $this->mDivisi->save($data);
        if($save)
        {
            $message = 'Data berhasil disimpan';
            return $message;
        }
        return $message;
    }

    private function update($id, $data = [])
    {
        $message = 'Something wrong';
        $save = $this->mDivisi->update($id, $data);
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
                $this->mDivisi->delete($id[$i]);
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
