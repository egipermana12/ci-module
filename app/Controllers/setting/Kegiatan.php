<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;
use App\Models\KalenderKerjaModel;
use App\Models\KalenderLabelModel;
use \Hermawan\DataTables\DataTable;

class Kegiatan extends BaseController
{
    private $modelKalender;
    private $label;
    public $validation;
    public function __construct()
    { 
        $this->data['site_title'] = 'Kagiatan Kerja';
        $this->addStyle( base_url() .'assets/css/page/calender-data-tables.css');
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addJs(base_url() .'assets/js/page/calender-kegiatan.js');

        $this->modelKalender = new KalenderKerjaModel();
        $this->label = new KalenderLabelModel();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $this->data['labelkagegori'] = $this->label->findAll();
        return view('setting/kegiatan/index', $this->data);
    }

    public function fetchData()
    {
        if($this->request->isAJAX()){
            $data = $this->modelKalender->select('id,id_kalender_label,tgl_mulai_kegiatan,tgl_selesai_kegiatan,nm_kegiatan');
            return DataTable::of($data)
            ->filter(function($data, $request){
                if ($request->id_label){
                    $data->where('id_kalender_label', $request->id_label);
                }
            })
            ->add('aksi', function($row){
                return '<div class="d-flex justify-content-center text-center"><a href="javascript:void(0)" class="text-success" title="Edit" onclick="edit('.$row->id.')"><i class="fas fa-solid fa-pen-to-square"></i></a><span class="px-2"></span><a href="javascript:void(0)" title="Hapus" class="text-danger" onclick="hapus('.$row->id.')"><i class="fas fa-solid fa-eraser"></i></a></div>';
            }, 'last')
            ->format('tgl_mulai_kegiatan', function($value){
                return tglindo($value, true);
            })
            ->format('tgl_selesai_kegiatan', function($value){
                return tglindo($value, true);
            })
            ->addNumbering('no')
            ->hide('id,id_kalender_label')
            ->toJson(true);
        }else{
            return redirect()->to('/');
        }
    }   

    function new()
    {
        if ($this->request->isAJAX())
        {
            $label = $this->label->findAll();
            $data = [
                'judul' => 'Tambah Kegiatan Baru',
                'tgl_mulai_kegiatan' => '',
                'tgl_selesai_kegiatan' => '',
                'tgl_kegiatan' => '',
                'nm_kegiatan' => '',
                'id' => '',
                'id_kalender_label' => '',
                'label' => $label
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/kegiatan/form', $data)
            ]); 
        }else{
            return redirect()->to('/');
        }
    }

    public function edit($id)
    {
        if ($this->request->isAJAX())
        {
            $label = $this->label->findAll();
            $find = $this->modelKalender->find($id);
            $data = [
                'judul' => 'Tambah Kegiatan Baru',
                'tgl_mulai_kegiatan' => $find['tgl_mulai_kegiatan'],
                'tgl_selesai_kegiatan' => $find['tgl_selesai_kegiatan'],
                'tgl_kegiatan' => $find['tgl_mulai_kegiatan'] .' s/d '.$find['tgl_selesai_kegiatan'],
                'nm_kegiatan' => $find['nm_kegiatan'],
                'id' => $id,
                'id_kalender_label' => $find['id_kalender_label'],
                'label' => $label
            ];
            return $this->response->setJSON([
                'err' => false,
                'data' => view('setting/kegiatan/form', $data)
            ]); 
        }else{
            exit('maaf tidak dapat diproses');
        }
    }

    function create()
    {
        if ($this->request->isAJAX()){
             $id = $this->request->getPost('id');
            $data = [
                'nm_kegiatan' => $this->request->getPost('nm_kegiatan'),
                'tgl_mulai_kegiatan' => $this->request->getPost('tgl_mulai_kegiatan'),
                'tgl_selesai_kegiatan' => $this->request->getPost('tgl_selesai_kegiatan'),
                'tgl_kegiatan' => $this->request->getPost('tgl_kegiatan'),
                'id_kalender_label' => $this->request->getPost('id_kalender_label')
            ];
            $rules = 
            [
                'nm_kegiatan' => 'required',
                'tgl_mulai_kegiatan' => 'required|valid_date',
                'tgl_selesai_kegiatan' => 'required|valid_date',
                'tgl_kegiatan' => 'required',
                'id_kalender_label' => 'required',
            ];
            $messages = 
            [
                'nm_kegiatan' => [
                    'required' => 'Nama kegiatan tidak boleh kosong'
                ],
                'tgl_mulai_kegiatan' => [
                    'required' => 'Tanggal mulai tidak boleh kosong',
                    'valid_date' => 'Tanggal tidak sesuai'
                ],
                'tgl_selesai_kegiatan' => [
                    'required' => 'Tanggal selesai tidak boleh kosong',
                    'valid_date' => 'Tanggal tidak sesuai'
                ],
                'tgl_kegiatan' => [
                    'required' => 'Tanggal tidak boleh kosong'
                ],
                'id_kalender_label' => [
                    'required' => 'Label kegiatan belum dipilih'
                ],
            ];
            if(!$this->validate($rules, $messages)){
            return $this->response->setJSON([
                'err' => true,
                'messages' => $this->validation->getErrors()
            ]);
            }else{
                if($id === '')
                {
                    $save = $this->modelKalender->save($data);
                    return $this->response->setJSON([
                        'err' => false,
                        'messages' => $save
                    ]);
                }else{
                    $update = $this->modelKalender->update($id, $data);
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

    public function delete()
    {
        if($this->request->isAJAX()){
            $id = $this->request->getPost('id');
            $this->modelKalender->delete($id);
            return $this->response->setJSON([
                'messages' => 'Data berhasil di delete!'
            ]);
        }else{
            return redirect()->to('/');
        }
    }

    //batas
}
