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

    // Tambahkan pengecekan dan default value
    $id_kategori = $id_kategori ?? ''; // Atur default value jika $id_kategori tidak terdefinisi

    $data = [
        'current_page' => 'tambah_data',
        'page' => 'admin/kategori',
        'articles' => $articles,
        'categories' => $categories,
        'kategori_nama' => !empty($kategori) ? reset($kategori)['nama_kategori'] : '',
        'id_kategori' => $id_kategori, // Sertakan $id_kategori di data yang dikirim ke view
    ];

    $userRole = session()->get('tipe');

    if ($userRole === 'superuser') {
        return view('template_admin', $data);
    } elseif ($userRole === 'admin') {
        // ... (sama seperti sebelumnya)
    } else {
        return redirect()->to('/dashboard');
    }
}
    
    public function addarticle()
    {
        $datminModel = new Dafmin_Model();
        $adminData = $datminModel->getAdminData();

        // Get the name of the logged-in admin from the session
        $namaAdmin = session()->get('nama_admin');

        $datminModel = new Dafmin_Model();
        $pembuatList = $datminModel->getPembuatList();

        $data = [
            'current_page' => 'tambah_data',
            'page' => 'admin/tambah_data',
            'adminData' => $adminData,
            'pembuatList' => $pembuatList,
            'nama_admin' => $namaAdmin,
            // Pass the name of the admin to the view
        ];

        // Check the user's role (tipe) from the session
        $userRole = session()->get('tipe');

        if ($userRole === 'superuser') {
            // Load the superuser template view
            return view('template_admin', $data);
        } elseif ($userRole === 'admin') {
            // Check if the admin status is 'nonaktif', and if so, logout and redirect
            $datminModel = new Dafmin_Model();
            $userId = session()->get('user_id');
            $admin = $datminModel->find($userId);

            if ($admin['status'] === 'nonaktif') {
                // Logout the admin
                session()->destroy();
                return redirect()->to('/login-admin')->with('error', 'Akun Anda telah dinonaktifkan.');
            }

            // Load the admin template view
            return view('admin_2', $data);
        } else {
            // Handle other roles or invalid roles here (e.g., redirect to a default page)
            return redirect()->to('/default-page');
        }
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

        $save = $model->insert($data);

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
        // Check if the user is not logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

        $model = new User_Model();
        $artikel = $model->getArticle($id)->getRow();

        $datminModel = new Dafmin_Model();
        $pembuatList = $datminModel->getPembuatList();

        // Get the name of the admin who created the article
        $adminName = $artikel->pembuat;

        $data = [
            'current_page' => 'edit_data',
            'page' => 'admin/edit_data',
            'artikel' => $artikel,
            'pembuatList' => $pembuatList,
            'adminName' => $adminName,
            // Pass the admin's name to the view
        ];

        // Check the user's role (tipe) from the session
        $userRole = session()->get('tipe');

        if ($userRole === 'superuser') {
            // Load the superuser template view
            return view('template_admin', $data);
        } elseif ($userRole === 'admin') {
            // Check if the admin status is 'nonaktif', and if so, logout and redirect
            $datminModel = new Dafmin_Model();
            $userId = session()->get('user_id');
            $admin = $datminModel->find($userId);

            if ($admin['status'] === 'nonaktif') {
                // Logout the admin
                session()->destroy();
                return redirect()->to('/login-admin')->with('error', 'Akun Anda telah dinonaktifkan.');
            }

            // Load the admin template view
            return view('admin_2', $data);
        } else {
            // Handle other roles or invalid roles here (e.g., redirect to a default page)
            return redirect()->to('/dashboard');
        }
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