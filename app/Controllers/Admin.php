<?php

namespace App\Controllers;

use App\Models\Kategori_Model;
use CodeIgniter\Controller;
use App\Models\User_Model;

class Admin extends Controller
{
    public function dashboard()
    {
        $data = [
            'current_page' => 'dashboard',
            'page' => 'admin/dashboard',
        ];
        return view('template_admin', $data);
    }
    public function kategori($id_kategori)
    {
        $kategoriModel = new Kategori_Model();
        $categories = $kategoriModel->getCategories();
        $articles = $kategoriModel->getArticlesByKategori($id_kategori);

        //cari nama kategori berdasarkan id_kategori yang dipilih
        $kategori_nama = '';
        foreach ($categories as $kategori) {
            if ($kategori['id_kategori'] == $id_kategori) {
                $kategori_nama = $kategori['nama_kategori'];
                break;
            }
        }

        $data = [
            'current_page' => 'dashboard',
            'page' => 'admin/kategori',
            'articles' => $articles,
            'categories' => $categories,
            'kategori_nama' => $kategori_nama
        ];
        return view('template_admin', $data);
    }
    public function hapus($id)
    {
        $model = new User_Model();

        //ambil id_kategori dari artikel yang akan dihapus
        $id_kategori = $model->getArticle($id)->getRow('id_kategori');

        if (isset($id_kategori)) {
            $model->hapus_data($id);
            $redirect_url = site_url('Admin/kategori/' . $id_kategori);
            echo '<script>
                alert("Selamat! Data berhasil terhapus.");
                window.location="' . $redirect_url . '"
            </script>';
        } else {
            $redirect_url = site_url('Admin/kategori/' . $id_kategori);
            echo '<script>
                alert("Data gagal dihapus.");
                window.location="' . $redirect_url . '"
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
        $id_kategori = $this->request->getPost('id_kategori'); // Ambil id_kategori dari input form

        // Proses upload gambar
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/img/', $newName);
        } else {
            $newName = null;
        }

        $data = array(
            'judul' => $judul,
            'konten' => $konten,
            'gambar' => $newName,
            'id_kategori' => $id_kategori
        );

        $model->simpan($data);

        $redirect_url = site_url('Admin/kategori/' . $id_kategori); // Redirect ke halaman kategori yang sesuai
        echo '<script>
                alert("Selamat! Berhasil Menambah Data Artikel");
                window.location="' . $redirect_url . '"
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
            // Jika pembaruan berhasil, redirect ke halaman kategori yang sesuai
            $redirect_url = site_url('Admin/kategori/' . $getId->id_kategori);
            echo '
        <script>
            alert("Selamat! Berhasil Mengupdate Data Artikel");
            window.location="' . $redirect_url . '"
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

    public function hapuskategori($id)
    {
        $model = new Kategori_Model();
        $kategori = $model->getCategories($id);

        if ($kategori !== null) {
            $model->hapus($id);
            $redirect_url = site_url('Admin/dashboard'); // Redirect to the category main page after successful deletion
            echo '<script>
            alert("Selamat! Data berhasil terhapus.");
            window.location="' . $redirect_url . '"
        </script>';
        } else {
            // Jika data kategori tidak ditemukan, maka redirect kembali ke halaman kategori utama
            $redirect_url = site_url('Admin/dashboard');
            echo '<script>
            alert("Data gagal dihapus atau tidak ditemukan.");
            window.location="' . $redirect_url . '"
        </script>';
        }
    }
}