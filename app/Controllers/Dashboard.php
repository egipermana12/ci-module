<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct()
    { 
        $this->data['site_title'] = 'Dashboard';
    }

    public function index()
    {
        return view('Dashboard', $this->data);
    }
}
