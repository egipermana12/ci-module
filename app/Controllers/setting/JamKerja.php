<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;
use App\Models\JamKerjaModel;
use \Hermawan\DataTables\DataTable;

class JamKerja extends BaseController
{
    public $validation;
    public $mJam;
    public function __construct()
    {
        $this->data['site_title'] = 'Jam Kerja';
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addJs(base_url() .'vendors/timepicker/timepicker.js');
        $this->addStyle(base_url() .'vendors/timepicker/timepicker.css');
        $this->addStyle( base_url() .'assets/css/page/unit-kerja.css');
        $this->addJsBawah(base_url() .'assets/js/page/jam-kerja.js');
        $this->validation =  \Config\Services::validation();
        $this->mJam = new JamKerjaModel;
    }

    public function index()
    {
        return $this->getView('setting/jamkerja/index', $this->data);
    }

    public function fetchData()
    {
        if($this->request->isAJAX()){
            $data = $this->mJam->select('id_jam_kerja,nm_shift,jam_mulai_kerja,jam_selesai_kerja');
            return DataTable::of($data)
            ->add('aksi', function($row){
                return '<input class="form-check-input cb-custom jamcb" name="jamcb" type="checkbox" value="'.$row->id_jam_kerja.'">';
            })
            ->addNumbering('no')
            ->hide('id_jam_kerja')
            ->toJson(true);
        }else{
            return redirect()->to('/');
        }
    }

    public function new()
    {
        if($this->request->isAJAX()){
            $data = [
                'judul' => 'Tambah Jam Kerja',
                'nm_shift' => '',
                'jam_mulai_kerja' => '',
                'jam_selesai_kerja' => '',
                'id' => '',
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/jamkerja/form', $data)
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    public function edit($id)
    {
        if($this->request->isAJAX()){
            $find = $this->mJam->find($id); //ganti find
            $data = [
                'judul' => 'Update Jam Kerja',
                'nm_shift' => $find['nm_shift'],
                'jam_mulai_kerja' => $find['jam_mulai_kerja'],
                'jam_selesai_kerja' => $find['jam_selesai_kerja'],
                'id' => $find['id_jam_kerja'],
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/jamkerja/form', $data)
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
                'nm_shift' => $this->request->getPost('nm_shift'),
                'jam_mulai_kerja' => $this->request->getPost('jam_mulai_kerja'),
                'jam_selesai_kerja' => $this->request->getPost('jam_selesai_kerja')
            ];
            $rules = [
                'nm_shift' => 'required',
                'jam_mulai_kerja' => 'required|checkFormatJam[jam_mulai_kerja]',
                'jam_selesai_kerja' => 'required|checkFormatJam[jam_selesai_kerja]',
            ];
            $messages = [
                'nm_shift' => [
                    'required' => 'Data Nama Shift Tidak boleh kosong!'
                ],
                'jam_mulai_kerja' => [
                    'required' => 'Jam mulai tidak boleh kosong',
                    'checkFormatJam' => 'Format jam salah'
                ],
                'jam_selesai_kerja' => [
                    'required' => 'Jam selesai tidak boleh kosong',
                    'checkFormatJam' => 'Format jam salah'
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
        $save = $this->mJam->save($data);
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
        $save = $this->mJam->update($id, $data);
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
                $this->mJam->delete($id[$i]);
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
