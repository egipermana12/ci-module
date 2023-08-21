<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PagawaiImportSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 400; $i++) {
            $this->db->table('t_data_pegawai_tmp')->insert($this->generatePegawai());
        }
    }

    public function generatePegawai(): array
    {
        $faker = Factory::create();

        return [
            'nik'  => $faker->regexify('[A-Z]{4}[0-9]{3}'),
            'nm_pegawai' => $faker->name(),
            'tgl_lahir' =>  $faker->date(),       
            'jns_kelamin' =>  $faker->randomElement(['L', 'P']),       
            'no_hp' =>  $faker->regexify('^\+62[0-9]{12}$'),    
            'alamat' => $faker->address(),
            'id_unit_kerja' => $faker->randomElement(['1','2','3']),
            'id_divisi' => $faker->randomElement(['1','2','3','5','6']),
            'tgl_bergabung' =>  $faker->date(),
        ];
    }
}
