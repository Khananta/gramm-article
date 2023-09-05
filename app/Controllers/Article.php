<?php

namespace App\Controllers;

use App\Models\Dafmin_Model;
use App\Models\Kategori_Model;
use CodeIgniter\Controller;
use App\Models\User_Model;

class Article extends Controller
{
    public function article($id_kategori)
    {
        $kategoriModel = new Kategori_Model();
        $categories = $kategoriModel->getCategories();
        $articles = $kategoriModel->getArticlesByKategori($id_kategori);

        $kategori = array_filter($categories, function ($kategori) use ($id_kategori) {
            return $kategori['id_kategori'] == $id_kategori;
        });

        if (!session()->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

        $data = [
            'page' => 'admin/kategori',
            'articles' => $articles,
            'categories' => $categories,
            'kategori_nama' => !empty($kategori) ? reset($kategori)['nama_kategori'] : '',
        ];

        return view('template_admin', $data);
    }
    public function addarticle()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

        $datminModel = new Dafmin_Model();
        $adminData = $datminModel->getAdminData();

        $datminModel = new Dafmin_Model();
        $pembuatList = $datminModel->getPembuatList();

        $data = [
            'current_page' => 'tambah_data',
            'page' => 'admin/tambah_data',
            'adminData' => $adminData,
            'pembuatList' => $pembuatList,
        ];

        return view('template_admin', $data);
    }
    public function savearticle()
    {
        $model = new User_Model();
        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $gambar = $this->request->getFile('gambar');
        $id_kategori = $this->request->getPost('id_kategori');
        $status = $this->request->getPost('status');
        $pembuat = $this->request->getPost('pembuat');
        $last_updated = date('Y-m-d H:i:s');

        // proses upload gambar
        $newName = null;
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/img/', $newName);
        }

        $data = [
            'judul' => $judul,
            'konten' => $konten,
            'gambar' => $newName,
            'id_kategori' => $id_kategori,
            'status' => $status,
            'pembuat' => $pembuat,
            'last_updated' => $last_updated
        ];

        $save=$model->insert($data);

        if ($save) {
            // jika pembaruan berhasil, redirect ke halaman kategori yang sesuai
            $redirect_url = site_url('/article/' . $id_kategori); // redirect ke halaman kategori yang sesuai
            echo '
        <script>
            alert("Selamat! Berhasil membuat Data Artikel");
            window.location="' . $redirect_url . '"
        </script>';
        } else {
            die('Pembuatan data tidak berhasil');
        }
    }
    public function editarticle($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

        $model = new User_Model();
        $artikel = $model->getArticle($id)->getRow();

        $datminModel = new Dafmin_Model();
        $pembuatList = $datminModel->getPembuatList();

        $data = [
            'current_page' => 'edit_data',
            'page' => 'admin/edit_data',
            'artikel' => $artikel,
            'pembuatList' => $pembuatList,
        ];

        return view('template_admin', $data);
    }
    public function updatearticle()
    {
        $model = new User_Model();

        // ambil data yang dikirim melalui POST
        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $gambar = $this->request->getFile('gambar');
        $status = $this->request->getPost('status');
        $pembuat = $this->request->getPost('pembuat');
        $last_updated = date('Y-m-d H:i:s');

        $getId = $model->getArticle($id)->getRow();

        // proses upload gambar jika ada
        $newName = $getId->gambar;
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/img/', $newName);

            // hapus gambar sebelumnya jika ada
            if (!empty($getId->gambar)) {
                unlink(ROOTPATH . 'public/img/' . $getId->gambar);
            }
        }

        $data = [
            'judul' => $judul,
            'konten' => $konten,
            'gambar' => $newName,
            'status' => $status,
            'pembuat' => $pembuat,
            'last_updated' => $last_updated
        ];

        // panggil fungsi edit dari model dengan parameter data dan id artikel
        $update = $model->editDataArticle($data, $id);

        if ($update) {
            // jika pembaruan berhasil, redirect ke halaman kategori yang sesuai
            $redirect_url = site_url('/article/' . $getId->id_kategori);
            echo '
        <script>
            alert("Selamat! Berhasil Mengupdate Data Artikel");
            window.location="' . $redirect_url . '"
        </script>';
        } else {
            die('Pembaruan data tidak berhasil');
        }
    }
    public function deletearticle()
    {
        $articleToDelete = $this->request->getPost('article_to_delete');

        if ($articleToDelete) {
            $articleModel = new User_Model();
            foreach ($articleToDelete as $articleId) {
                $articleModel->deleteArticle($articleId);
            }

            $response = [
                'status' => 'success',
                'message' => 'Artikel berhasil dihapus.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Gagal menghapus data.'
            ];
        }

        return $this->response->setJSON($response);
    }
}