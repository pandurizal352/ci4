<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $KomikModel;
    public function __construct()
    {
        //model construct ini supaya bisa di pake di mana pun dan harus butuh protected $KomikModel;
        $this->KomikModel = new KomikModel();
    }

    public function index()
    {
        /*
        cara konek db tanpa model
        $db = \config\Database::connect();
        $komik = $db->query("select * from komik");
        foreach ($komik->getResultArray() as $row) {
        d($row);
        }
        cara lama
        $KomikModel = new \App\Models\KomikModel();
        */
        // $Komik = $this->KomikModel->findAll();

        $data = [
            'title' => 'Komik || index ',
            'komik' => $this->KomikModel->getKomik(),
        ];



        return view('Komik/index', $data);
    }

    public function detail($slug)
    {
        // $komik = $this->KomikModel->getKomik($slug);
        $data = [
            'title' => 'Detail komik ',
            'komik' => $this->KomikModel->getKomik($slug)
        ];

        // jika komik tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul komik ' . $slug . '  tidak di temukan');
        }
        return view('komik/detail', $data);
    }

    public function create()
    {
        // $komik = $this->KomikModel->getKomik($slug);
        // session nya pindahin ke basecontroller supaya gak nulis lagi di setiap method
        //   session('validation');
        $data = [
            'title' => 'form data komik',
            'validation' => \Config\Services::validation()
        ];
        return view('komik/create', $data);
    }
    public function save()
    {
        //validasi input
        if (!$this->validate([
            'judul'  => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus di isi.',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                // uploaded = harus di upload
                // max_size = mau ukuran brp aja msal berapa kilobite 
                // max_dims = ukuran mau brp maximal misal tinggi nya brp atau lebar nya berapa
                // mime_in = file type nya harus gambar
                // ext_in = exstensi dari file yang mau di upload misal jpg,png,gif
                // is_image = khusus gambar aja 
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {

            // $validation = \Config\Services::validation();
            // return redirect()->to('/komik/create')->withInput()->with('validation',$validation);
            return redirect()->to('/komik/create')->withInput();
            // validation dari save ngrim semua input di ambil validation nya ke create dan jalaninn session
        }

        // getVar() bisa ngambil request apapun mau get atau pun post

        // ambil gambar nya broo
        $fileSampul = $this->request->getFile('sampul');
        //apakah tidak ada gambar yang di upload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // generet nama sampul rendem
            $namaSampul = $fileSampul->getRandomName();
            // mindahin file ke folder img
            $fileSampul->move('img', $namaSampul);
        }
        // // ambil nama file
        // $namaSampul = $fileSampul->getName();

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->KomikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul

        ]);

        session()->setFlashdata('pesan', 'data berhasil di tambah kan');

        return redirect()->to('/komik');
    }
    public function delete($id)
    {
        // cari gamabr berdasar kan id
        $komik = $this->KomikModel->find($id);
        // cek jika file gambar default
        if ($komik['sampul'] != 'default.jpg') {
            // hapus gambar
            unlink('img/' . $komik['sampul']);
        }

        $this->KomikModel->delete($id);
        session()->setFlashdata('pesan', 'data berhasil di hapus ');

        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'form ubah data komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->KomikModel->getKomik($slug)
        ];
        return view('komik/edit', $data);
    }
    public function update($id)
    {
        //cek judul
        $komik_lama = $this->KomikModel->getKomik($this->request->getVar('slug'));
        if ($komik_lama['judul'] == $this->request->getVar('judul')) {
            $rules_judul = 'required';
        } else {
            $rules_judul = 'required|is_unique[komik.judul]';
        }


        if (!$this->validate([
            'judul'  => [
                'rules' => $rules_judul,
                'errors' => [
                    'required' => '{field} komik harus di isi.',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                // uploaded = harus di upload
                // max_size = mau ukuran brp aja msal berapa kilobite 
                // max_dims = ukuran mau brp maximal misal tinggi nya brp atau lebar nya berapa
                // mime_in = file type nya harus gambar
                // ext_in = exstensi dari file yang mau di upload misal jpg,png,gif
                // is_image = khusus gambar aja 
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {

            // $validation = \Config\Services::validation();
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
            // validation dari save ngrim semua input di ambil validation nya ke create dan jalaninn session
        }

        $filesSampul = $this->request->getFile('sampul');
        // cek gambar,apakah tetap gambar lama
        if ($filesSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generet nama file rendem
            $namaSampul = $filesSampul->getRandomName();
            // pindahin gambar
            $filesSampul->move('img', $namaSampul);
            // hapus file laama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->KomikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul

        ]);

        session()->setFlashdata('pesan', 'data berhasil di ubah');

        return redirect()->to('/komik');
    }
}
