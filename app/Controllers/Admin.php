<?php

namespace App\Controllers;

use App\Models\Kategori_Model;
use CodeIgniter\Controller;
use App\Models\User_Model;

class Admin extends Controller
{
    public function home() 
    {
        $data = [
            'current_page' => 'dashboard',
            'page' => 'admin/home',
        ];
        return view('template_admin', $data);
    }

    public function dashboard()
    {
        $data = [
            'current_page' => 'dashboard',
            'page' => 'admin/kategori',
        ];
        return view('template_admin', $data);
    }
    public function hapus($id)
    {
        $model = new User_Model;
        $getNama = $model->getArticle($id)->getRow();
        
        if (isset($getNama)) {
            $model->hapus_data($id);
            echo '<script>
                    alert("Selamat! Data berhasil terhapus.");
                    window.location="' . base_url('Admin/dashboard') . '"
                </script>';
        } else {
 
            echo '<script>
                    alert("Gagal Menghapus !, Artikel ' . ' Tidak ditemukan");
                    window.location="' . base_url('Admin/dashboard') . '"
                </script>';
        }
    }
    public function tambahData()
    {
        $data = [
            'current_page' => 'tambah_data',
            'page' => 'admin/tambah_data',
        ];
        return view('template_admin', $data);
    }
    public function simpanData()
    {
        $model = new User_Model();
        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $gambar = $this->request->getFile('gambar');

        // Proses upload gambar
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/img/', $newName);
        }

        $data = array(
            'judul' => $judul,
            'konten' => $konten,
            'gambar' => $newName // Jika gambar tidak valid, akan menjadi null di database
        );

        $model->simpan($data);

        echo '<script>
                alert("Selamat! Berhasil Menambah Data Artikel");
                window.location="' . base_url('Admin/dashboard') . '"
            </script>';
    }

    public function edit($id)
    {
        $model = new User_Model();
        $getNama = $model->getArticle($id)->getRow();

        if ($getNama) {
            $data = [
                'current_page' => 'edit_data',
                'page' => 'admin/edit_data',
                'artikel' => $getNama, // Menyimpan data artikel ke dalam array
            ];
            return view('template_admin', $data);
        } else {
            die('Data tidak ditemukan.');
        }
    }

    public function updateData()
    {
        $model = new User_Model();

        // Ambil data yang dikirim melalui POST
        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $gambar = $this->request->getFile('gambar');

        $getId = $model->getArticle($id)->getRow();

        // Proses upload gambar jika ada
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/img/', $newName);

            // Hapus gambar sebelumnya jika ada
            if (!empty($getId->gambar)) {
                unlink(ROOTPATH . 'public/img/' . $getId->gambar);
            }
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang sudah ada sebelumnya
            $newName = $getId->gambar;
        }

        $data = array(
            'judul' => $judul,
            'konten' => $konten,
            'gambar' => $newName
        );

        // Panggil fungsi edit dari model dengan parameter data dan id artikel
        $update = $model->edit($data, $id);

        if ($update) {
            // Jika pembaruan berhasil, redirect ke halaman daftar data
            echo '
            <script>
                alert("Selamat! Berhasil Mengupdate Data Artikel");
                window.location="' . base_url('Admin/dashboard') . '"
            </script>';
        } else {
            die('Pembaruan data tidak berhasil');
        }
    }

    public function tambahkategori()
    {
        $model = new Kategori_Model();
        $nama_kat = $this->request->getPost('nama_kategori');

        $data = array(
            'nama_kategori' => $nama_kat
        );

        $model->simpan($data);
        echo '<script>
                alert("Selamat! Berhasil Menambah Kategori Artikel");
                window.location="' . base_url('Admin/dashboard') . '"
            </script>';
    }
}