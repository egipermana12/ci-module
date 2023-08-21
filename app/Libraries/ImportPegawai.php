<?php
/**
 * untuk import data pegawai
 */

namespace App\Libraries;
use App\Models\PegawaiModelTmp;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use CodeIgniter\I18n\Time;

class ImportPegawai {
    public function importExcel($excel, $filename){
        $model = new PegawaiModelTmp();

        $reader      = new Xls();
        $spreadsheet = $reader->load($excel);
        $worksheet   = $spreadsheet->getActiveSheet();
        // $heighestRow = $worksheet->getHighestRow() - 1;
        $data_sheet  = $worksheet->toArray();

        foreach($data_sheet as $key => $val){
            if($key == 0){
                continue;
            }

            $ambilTgl_lahir = $val[2];
            if(preg_match("/^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[0-2])\/\d{4}$/", $ambilTgl_lahir)){
                $tgl_lahir = reverse_tgl($val[2]);
            }else{
                $tgl_lahir = $val[2];
            }
            
            $importData = [
                'nik'           => $val[0],
                'nm_pegawai'    => $val[1],
                'tgl_lahir'     => $tgl_lahir,
                'jns_kelamin'   => $val[3],
                'no_hp'         => $val[4],
                'alamat'        => $val[5],
                'kd_prov'       => $val[6],
                'kd_kab_kota'   => $val[7],
                'kd_kec'        => $val[8],
                'kd_kel'        => $val[9],
                'id_unit_kerja' => $val[10],
                'id_divisi'     => $val[11],
                'tgl_bergabung' => $val[12],
                'keyfile_flat'  => $filename
            ];
            // $model->insert($importData);   
            $persentase = $val[2];
        }

        return $data_sheet;
        
    }
}
