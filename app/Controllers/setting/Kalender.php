<?php

namespace App\Controllers\Setting;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use App\Libraries\Calendar;
use App\Models\KalenderLabelModel;

class Kalender extends BaseController
{
    protected $calendar;
    private $mKalenderLabel;
    public function __construct()
    { 
        $this->mKalenderLabel = new KalenderLabelModel();

        $this->data['site_title'] = 'Kalender Kerja';
        $this->addStyle( base_url() .'assets/css/page/calender.css');
        $this->addJs( base_url() .'assets/js/page/calender.js');

        $myTime = Time::now()->format('Y-m-d');
        $this->calendar = new Calendar($myTime);
    }

    public function index()
    {
        $this->data['labelKalender'] = $this->mKalenderLabel->findAll();

        $coba = $this->calendar->generateKalender();
        $this->data['time'] = $coba;
        return view('setting/kalender_kerja', $this->data);
    }
}
