<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;

class LabelKalender extends BaseController
{
    public function __construct()
    {
        $this->data['site_title'] = 'Kalender Label';
        $this->addStyle( base_url() .'assets/css/page/calender.css');
        $this->addJs( base_url() .'assets/js/page/calender.js');
    }

    public function index()
    {
        return view('setting/kalenderlabel/index', $this->data);    
    }
}
