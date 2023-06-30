<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        // cek data dummi
        // $faker = \Faker\Factory::create();
        // dd($faker->address);

        $data = [
            'title' => 'home || index ',
            'tes' => ['satu', 'dua', 'tiga']
        ];

        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'home || About me '
        ];
        //view layoting manual

        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'home || Contact',
            'alamat' => [
                [
                    'tipe' => 'kampus',
                    'alamat' => 'Jl. nin aja dulu siapa tau sukses aamiin',
                    'Kota' => 'Bandung',
                ],
                [
                    'tipe' => 'kantor',
                    'alamat' => 'Jl. sama kamu berdua keliling kota',
                    'Kota' => 'Bandung',
                ],

            ]
        ];
        //view layoting manual

        return view('pages/contact', $data);
    }
}
