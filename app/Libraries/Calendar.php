<?php
/**
 * untuk membuat list calender dalam 1 tahun
 * digunakan untuk menampilkan kaleder kerja 1 tahun
 */

namespace App\Libraries;
use App\Models\KalenderKerjaModel;

class Calendar
{
    private $tahun_aktif, $bulan_aktif, $tgl_aktif, $hari_aktif;
    private $bulan_loop =0;
    private $modelKeja;

    public function __construct($tanggal)
    {
        $this->tahun_aktif = $tanggal != null ? date('Y', strtotime($tanggal)) : date('Y');
        $this->bulan_aktif = $tanggal != null ? date('n', strtotime($tanggal)) : date('m');
        $this->tgl_aktif = $tanggal != null ? date('d', strtotime($tanggal)) : date('d');
    }
    
    public function generateKalender()
    {
        $kegiatans = $this->modelKeja = new KalenderKerjaModel();
        $kegiatan = $kegiatans->generateTglWarna($this->tahun_aktif);
        $bulan = array ('Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $hari = array ( 1 =>    'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );
        $html = [];
        $html[] = '<div class="d-flex flex-column justify-content-center align-items-center">';
        $html[] = '<h1 class="fs-2 text-danger fw-bold"> '.$this->tahun_aktif.'</h1>';
        
        //table of month
        for($row = 1; $row <= 4; $row++) //banyak bulan kebawah
        {
            $html[] = '<div class="d-flex">';
            for($column = 1; $column <=3; $column++)
            {
                //untuk kegiatan dibawah kalender perbulan
                $listKegiatan = [];

                $html []= '<div class="d-flex flex-column py-1 px-4">';

                $this->bulan_loop++;

                // Month Cell
                $first_day_in_month=date('w',mktime(0,0,0,$this->bulan_loop,1,$this->tahun_aktif));
                $month_days=date('t',mktime(0,0,0,$this->bulan_loop,1,$this->tahun_aktif));


                // in PHP, Sunday is the first day in the week with number zero (0)
                // to make our calendar works we will change this to (7)
                if ($first_day_in_month==0){
                  $first_day_in_month=7;
                }

              $html[] = '<table class="calendar my-2">';
              $classMontActive = $this->bulan_loop == $this->bulan_aktif ? 'text-danger fw-bold fs-6' : 'text-black fw-semibold fs-6';
              $html[] = '<tr><td colspan="7" class="'.$classMontActive.' text-uppercase text-center mb-2 border-bottom" style="height: 20px;">'.$bulan[$this->bulan_loop - 1].'</td></tr>';
              $html[] = '<tr class="nama_hari" style="height: 44px;">
              <td class="p-2 text-center fw-semibold">Sen</td>
              <td class="p-2 text-center fw-semibold">Sel</td>
              <td class="p-2 text-center fw-semibold">Rab</td>
              <td class="p-2 text-center fw-semibold">Kam</td>
              <td class="p-2 text-center fw-semibold">Jum</td>
              <td class="p-2 text-center fw-semibold text-danger">Sab</td>
              <td class="p-2 text-center fw-semibold text-danger">Min</td>
              </tr>
              ';
              $html[] = '<tr>';
              for($i = 1; $i < $first_day_in_month; $i++){
                $html[] = '<td> </td>'; //blank kosong jika bukan hari pertama dibulan tersebut
            }

            $cekBln = $this->tahun_aktif.'-'.sprintf("%02d",$this->bulan_loop);
            foreach($kegiatan as $val){
                $valYearBln = date('Y-m', strtotime($val['tgl_mulai_kegiatan']));
                
                $valStartTgl = date('d', strtotime($val['tgl_mulai_kegiatan']));
                $valEndTgl = date('d', strtotime($val['tgl_selesai_kegiatan']));
                if($valStartTgl == $valEndTgl) {
                    $valTgl = $valStartTgl;
                }else{
                    $valTgl = $valStartTgl . ' - '. $valEndTgl;
                }

                $valBln = intval(date('m', strtotime($val['tgl_mulai_kegiatan'])));
                $blnTrim = substr($bulan[$valBln - 1], 0, 3);

                if($valYearBln == $cekBln){
                    $listKegiatan []= '<p class="fw-medium text-capitalize" style="color:'.$val['warna'].';">'.$valTgl .' '. $blnTrim .' : '. $val['nm_kegiatan'] .'</p>';
                }
            }           

            for($day = 1; $day <= $month_days; $day++){
                $hari = ($day+$first_day_in_month - 1)%7;
                $style = '';
                $class = (($day==$this->tgl_aktif) && ($this->bulan_loop == $this->bulan_aktif)) ? 'bg-success text-white  rounded-circle' : '';
                $class .= ($hari == 6) ? ' sab' : '';
                $class .= ($hari == 0) ? ' min' : '';
                if(strlen($this->bulan_loop) == 1){
                    $cekBulan = '0'.$this->bulan_loop;
                }else{
                    $cekBulan = $this->bulan_loop;
                }
                if(strlen($hari) == 1){
                    $cekHari = '0'.$hari;
                }else{
                    $cekHari = $hari;
                }

                $cekTgl = $this->tahun_aktif.'-'.$cekBulan.'-'.sprintf("%02d",$day);

                //cek jika hari,bulan, tahun ada di db dan sama dg tgl hari ini
                foreach($kegiatan as $val){
                    if($cekTgl >= $val['tgl_mulai_kegiatan'] && $cekTgl <= $val['tgl_selesai_kegiatan']){
                        $class .= ' text-white';
                        $style = 'background: '.$val['warna'];
                    }
                }
                
                //loop tgl
                $html[] = '<td class="'.$class.' p-2 text-center fw-semibold calender-day" style="'.$style.'">'.sprintf("%02d",$day).'</td>';
                if($hari == 0) 
                {
                    $html[] = '</tr><tr>';
                }
            }
            $html[] = '</tr>';
            $html[] = '</table>'.implode('', $listKegiatan).'</div>';

        }
        $html[] = '</div>';
    }
    $html[] = '</div>';
    return implode('', $html); // Menggabungkan array menjadi satu string menggunakan implode()
    }
}
