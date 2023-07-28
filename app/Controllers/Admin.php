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
    public function category($id_kategori)
    {
        $kategoriModel = new Kategori_Model();
        $categories = $kategoriModel->getCategories();
        $articles = $kategoriModel->getArticlesByKategori($id_kategori);

        // cari nama kategori berdasarkan id_kategori yang dipilih menggunakan array_filter
        $kategori = array_filter($categories, function ($kategori) use ($id_kategori) {
            return $kategori['id_kategori'] == $id_kategori;
        });

        $data = [
            'current_page' => 'dashboard',
            'page' => 'admin/kategori',
            'articles' => $articles,
            'categories' => $categories,
            'kategori_nama' => !empty($kategori) ? reset($kategori)['nama_kategori'] : ''
        ];

        return view('template_admin', $data);
    }

    public function deleteArticle($id)
    {
        $model = new User_Model();
        $id_kategori = $model->getArticle($id)->getRow('id_kategori');

        if ($id_kategori !== null) {
            $model->deleteDataArticle($id);
            $response = [
                'status' => 'success',
                'message' => 'Selamat! Data berhasil terhapus.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data gagal dihapus atau tidak ditemukan.'
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function addArticle()
    {
        $data = [
            'current_page' => 'tambah_data',
            'page' => 'admin/tambah_data',
        ];
        return view('template_admin', $data);
    }
    public function saveArticle()
    {
        $model = new User_Model();
        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $gambar = $this->request->getFile('gambar');
        $id_kategori = $this->request->getPost('id_kategori'); // Ambil id_kategori dari input form

        // Proses upload gambar
        $newName = null;
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/img/', $newName);
        }

        $data = [
            'judul' => $judul,
            'konten' => $konten,
            'gambar' => $newName,
            'id_kategori' => $id_kategori
        ];

        $model->saveDataArticle($data);

        $redirect_url = site_url('Admin/category/' . $id_kategori); // Redirect ke halaman kategori yang sesuai
        echo '<script>
            alert("Selamat! Berhasil Menambah Data Artikel");
            window.location="' . $redirect_url . '"
            </script>';
    }
    public function editArticle($id)
    {
        $model = new User_Model();
        $artikel = $model->getArticle($id)->getRow();

        if ($artikel) {
            $data = [
                'current_page' => 'edit_data',
                'page' => 'admin/edit_data',
                'artikel' => $artikel,
            ];
            return view('template_admin', $data);
        } else {
            die('Data tidak ditemukan.');
        }
    }
    public function updateArticle()
    {
        $model = new User_Model();

        // Ambil data yang dikirim melalui POST
        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $gambar = $this->request->getFile('gambar');

        $getId = $model->getArticle($id)->getRow();

        // Proses upload gambar jika ada
        $newName = $getId->gambar;
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/img/', $newName);

            // Hapus gambar sebelumnya jika ada
            if (!empty($getId->gambar)) {
                unlink(ROOTPATH . 'public/img/' . $getId->gambar);
            }
        }

        $data = [
            'judul' => $judul,
            'konten' => $konten,
            'gambar' => $newName
        ];

        // Panggil fungsi edit dari model dengan parameter data dan id artikel
        $update = $model->editDataArticle($data, $id);

        if ($update) {
            // Jika pembaruan berhasil, redirect ke halaman kategori yang sesuai
            $redirect_url = site_url('Admin/category/' . $getId->id_kategori);
            echo '
        <script>
            alert("Selamat! Berhasil Mengupdate Data Artikel");
            window.location="' . $redirect_url . '"
        </script>';
        } else {
            die('Pembaruan data tidak berhasil');
        }
    }

    public function addCategory()
    {
        $model = new Kategori_Model();
        $nama_kat = $this->request->getPost('nama_kategori');

        $data = [
            'nama_kategori' => $nama_kat
        ];

        $model->saveCategory($data);
        echo '<script>
            alert("Selamat! Berhasil Menambah Kategori Artikel");
            window.location="' . base_url('Admin/dashboard') . '"
        </script>';
    }
    public function deleteCategory($id)
    {
        $model = new Kategori_Model();
        $kategori = $model->getCategories($id);

        if ($kategori !== null) {
            $model->deleteCategory($id);
            $response = [
                'status' => 'success',
                'message' => 'Selamat! Data berhasil terhapus.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data gagal dihapus atau tidak ditemukan.'
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}