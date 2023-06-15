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
    public function __construct()
    { 
        $this->data['site_title'] = 'Kagiatan Kerja';
        $this->addStyle( base_url() .'assets/css/page/calender-data-tables.css');
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
        $this->addJs(base_url() .'assets/js/page/calender-kegiatan.js');

        $this->modelKalender = new KalenderKerjaModel();
        $this->label = new KalenderLabelModel();
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
                return '<div class="d-flex justify-content-center text-center"><a href="javascript:void(0)" class="text-success" title="Edit" onclick="alert(\'edit customer: '.$row->id.'\')"><i class="fas fa-solid fa-pen-to-square"></i></a><span class="px-2"></span><a href="javascript:void(0)" title="Hapus" class="text-danger" onclick="alert(\'delete customer: '.$row->id.'\')"><i class="fas fa-solid fa-eraser"></i></a></div>';
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
    //batas
}
