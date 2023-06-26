<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct()
    { 
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
        return view('Dashboard', $this->data);
    }
}
