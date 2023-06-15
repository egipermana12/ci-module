<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;
use App\Models\KalenderLabelModel;

class LabelKalender extends BaseController
{
    public $models;
    public $validation;

    public function __construct()
    {
        $this->data['site_title'] = 'Kalender Label';
        $this->addStyle( base_url() .'assets/css/page/calender-data-tables.css');
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addJs(base_url() .'assets/js/page/calender-data-table.js');

        $this->models = new KalenderLabelModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $this->data['results'] = $this->models->findAll();
        return view('setting/kalenderlabel/index', $this->data);    
    }

    public function new()
    {
        if ($this->request->isAJAX())
        {
            $data = [
                'judul' => 'Tambah Label Baru',
                'nm_label' => '',
                'warna' => '#fdba74',
                'id' => ''
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/kalenderlabel/form', $data)
            ]); 
        }else{
            exit('maaf tidak dapat diproses');
        }
    }

    public function edit($id)
    {
        if ($this->request->isAJAX())
        {
            $find = $this->models->find($id);
            $data = [
                'judul' => 'Ubah Data Label',
                'nm_label' => $find['nm_label'],
                'warna' => $find['warna'],
                'id' => $id
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/kalenderlabel/form', $data)
            ]); 
        }else{
            exit('maaf tidak dapat diproses');
        }
    }

    public function fetchData()
    {
        if ($this->request->isAJAX()){
            $res = $this->models->findAll();
            $data = [];
            $no = 1;
            foreach($res as $r)
            {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $r['nm_label'];
                $row[] = '<div class="d-flex text-center"><div style="display: block; width: 20px; margin-right: 5px; height: 20px; border-radius: 4px ; background: '.$r['warna'].'; "></div>'.$r['warna'].'</div>';
                $row[] = '<div class="text-center"><a class="text-success mr-2" href="javascript:void(0)" title="Edit" onclick="edit('."'".$r['id']."'".')"><i class="fas fa-solid fa-pen-to-square"></i></a><span class="px-2"></span><a class="text-danger" href="javascript:void(0)" title="Delete" onclick="hapus('."'".$r['id']."'".')"><i class="fas fa-solid fa-eraser"></i></a></div>';
                $data[] = $row;
            }
            return $this->response->setJSON(['data' =>$data]);
        }else{
           exit('maaf tidak dapat diproses');
       }

   }

   public function create()
   {
     if ($this->request->isAJAX()){
        $id = $this->request->getPost('id');
        $data = [
            'nm_label' => $this->request->getPost('nm_label'),
            'warna' => $this->request->getPost('warna'),
        ];

        $rules = 
        [
            'nm_label' => 'required',
            'warna' => 'required'
        ];
        $messages = 
        [
            'nm_label' => [
                'required' => 'Label tidak boleh kosong'
            ],
            'warna' => [
                'required' => 'Warna tidak boleh kosong'
            ]
        ];
        if(!$this->validate($rules, $messages)){
            return $this->response->setJSON([
                'err' => true,
                'messages' => $this->validation->getErrors()
            ]);
        }else{
            if(empty($id))
            {
                $simpan = $this->models->save($data);
                return $this->response->setJSON([
                    'err' => false,
                    'messages' => $simpan
                ]);
            }else{
                $update = $this->models->update($id, $data);
                return $this->response->setJSON([
                    'err' => false,
                    'messages' => $update
                ]);
            }
        }
    }else{
            exit('akses ditolak');
        }
    }

    public function delete()
    {
        if($this->request->isAJAX()){
            $id = $this->request->getPost('id');
            $this->models->delete($id);
            return $this->response->setJSON([
                'messages' => 'Data berhasil di delete!'
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    //batas
}
