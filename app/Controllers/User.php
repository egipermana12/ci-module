<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function __construct()
    {
        $this->data['site_title'] = 'Data User';
        $this->addJs(base_url() .'vendors/DataTables/datatables.min.js');
        $this->addJs(base_url() .'vendors/DataTables/JSZip-2.5.0/jszip.min.js');
        $this->addJs(base_url() .'vendors/DataTables/pdfmake-0.2.7/pdfmake.min.js');
        $this->addJs(base_url() .'vendors/DataTables/Buttons-2.3.6/js/buttons.html5.min.js');
        $this->addJs(base_url() .'vendors/DataTables/pdfmake-0.2.7/vfs_fonts.js');
        $this->addStyle(base_url() .'vendors/DataTables/datatables.min.css');
    }
    public function index()
    {
        return view('user', $this->data);
    }
}
