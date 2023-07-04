<?php

namespace App\Validation;

class CustomValidation
{
    public function checkFormatJam(string $str, string $fields, array $data)
    {
        $rulesjam = '';
        $datajam = explode(':', $data['jam_selesai_kerja']);
        $jam = $datajam[0];
        $menit = $datajam[1];
        if($jam > 23 && $jam < 0 && $menit > 60 && $menit < 0){
            $rulesjam = false;
        }
        return $rulesjam;
    }
}
