<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;

class Kalender extends BaseController
{
    public function __construct()
    { 
        $this->data['site_title'] = 'Kalender Kerja';
    }

    public function index()
    {
        return view('setting/kalender_kerja', $this->data);
    }
}
