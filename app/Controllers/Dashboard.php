<?php

namespace App\Controllers;
use App\Models\UnitKerjaModel;
ini_set('max_execution_time', 0); 
ini_set('memory_limit','2048M');

class Dashboard extends BaseController
{
    protected $mUnitkerja;
    public function __construct()
    { 
        $this->mUnitkerja =  new UnitKerjaModel();
        $this->data['site_title'] = 'Dashboard';
        $this->addStyle(base_url() .'vendors/leaflet/leaflet.css');
        $this->addJs(base_url() .'vendors/leaflet/leaflet.js');
    }

    public function index()
    {
        $moduleStatus = $this->currentModule['id_module_status'];
        if ($moduleStatus != 1) {
            return $this->printError('Module ' . $this->currentModule['judul_module'] . ' sedang ' . strtolower($this->currentModule['nama_status']));
        }
        $currentStatus = $this->modulePermission['status'];
        if($currentStatus === 'disable'){
            return $this->printError('anda tidak mempunyai hak akses membuka modul ' . $this->currentModule['judul_module']);   
        }
        $geoJson = FCPATH . 'geojson/prov.geojson'; // Mendapatkan jalur fisik dari file
        $file = file_get_contents(realpath($geoJson)); // Membaca isi file
        $file = json_decode($file);
        $geoLokasi = $file->features;
        $this->data['geoLokasi'] = $geoLokasi;

         $coordinates = [
            [
                'nm_unit_kerja' => 'Koordinat Default',
                'alamat' => 'Alamat Default',
                'koordinat_lokasi' => '-6.248606, 107.117242',
                'koordinat_bidang' => '',
                'jarak_toleran' => '5',
                'gambar' => ''
            ],
        ];
        $markers = $this->mUnitkerja->findAll();
        if(count($markers) > 0){
            $this->data['markers'] = $markers;
        }else{
            $this->data['markers'] = $coordinates;
        }


        return view('Dashboard', $this->data);
    }
}
