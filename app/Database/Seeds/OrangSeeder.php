<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class OrangSeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //     [
        //         'nama'       => 'pandu',
        //         'alamat'     => 'Jl. ABC no.123',
        //         'created_at' => TIME::now(),
        //         'updated_at' => TIME::now()
        //     ],
        //     [
        //         'nama'       => 'fahrizal',
        //         'alamat'     => 'Jl. ABC no.456',
        //         'created_at' => TIME::now(),
        //         'updated_at' => TIME::now()
        //     ],
        //     [
        //         'nama'       => 'rizal',
        //         'alamat'     => 'Jl. ABC no.789',
        //         'created_at' => TIME::now(),
        //         'updated_at' => TIME::now()
        //     ]
        // ];
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 50; $i++) {


            $data = [
                'nama'       => $faker->name,
                'alamat'     => $faker->address,
                // 'created_at' => TIME::now(),
                'created_at' => TIME::createFromTimestamp($faker->unixTime()), //data yang di ambil oleh faker
                'updated_at' => TIME::now()
            ];

            // insert cuma 1 data
            $this->db->table('orang')->insert($data);
        }
        // Simple Queries
        // $this->db->query('INSERT INTO orang (nama, alamat,created_at,updated_at) VALUES(:nama:, :alamat:, :created_at:,:updated_at:)', $data);

        // Using Query Builder
        // $this->db->table('orang')->insertBatch($data);
    }
}
