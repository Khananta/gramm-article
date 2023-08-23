<?php

namespace App\Controllers;

use App\Models\Dafmin_Model;
use App\Models\Kategori_Model;
use CodeIgniter\Controller;
use App\Models\User_Model;
use CodeIgniter\I18n\Time;

class Admin extends Controller
{
    public function dashboard()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

        $datmin = new Dafmin_Model();
        $kategoriModel = new Kategori_Model();
        $categories = $kategoriModel->findAll();
        $userId = $session->get('user_id');
        $admin = $datmin->find($userId);

        $data = [
            'current_page' => 'dashboard',
            'page' => 'admin/dashboard',
            'categories' => $categories,
            'admin' => $admin
        ];

        return view('template_admin', $data);
    }

    public function addCategory()
    {
        $model = new Kategori_Model();

        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'status' => $this->request->getPost('status'),
            'last_updated' => Time::now()->toLocalizedString('yyyy-MM-dd HH:mm:ss'),
        ];

        $model->insert($data);

        $response = [
            'status' => 'success',
            'message' => 'Selamat! Berhasil Menambah Kategori Artikel'
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function DeleteCategory()
    {
        $categoriesToDelete = $this->request->getPost('category_to_delete');

        if ($categoriesToDelete) {
            $kategoriModel = new Kategori_Model();
            foreach ($categoriesToDelete as $kategoriId) {
                $kategoriModel->deleteCategory($kategoriId);
            }

            return redirect()->to('/Admin/dashboard')->with('success_message', 'Data admin terpilih berhasil dihapus.');
        }

        return redirect()->to('/Admin/dashboard')->with('error_message', 'Tidak ada data admin yang terpilih untuk dihapus.');
    }
    public function edit_kategori()
    {
        $kategoriId = $this->request->getPost('kategori_id');
        $editData = [
            'nama_kategori' => $this->request->getPost('edit_nama'),
            'status' => $this->request->getPost('edit_status'),
        ];

        $kategoriModel = new Kategori_Model();
        $kategoriModel->updateKategoriWithLastUpdated($kategoriId, $editData);

        return redirect()->to('/Admin/dashboard')->with('success_message', 'Data admin berhasil diperbarui.');
    }
    public function toggleKategoriStatus($kategoriId, $newStatus)
    {
        $kategoriModel = new Kategori_Model();

        // Pastikan $newStatus hanya bernilai 'active' atau 'inactive'
        if ($newStatus === 'aktif' || $newStatus === 'nonaktif') {
            $kategoriModel->where('id_kategori', $kategoriId)->set('status', $newStatus)->update();
        } else {
            return redirect()->back()->with('error', 'Nilai status tidak valid.');
        }

        return redirect()->to(site_url('Admin/dashboard'));
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

        if (!session()->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

        $data = [
            'current_page' => 'category',
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

        if (!session()->get('logged_in')) {
            // Simpan URL tujuan dalam sesi
            $destination = current_url(true)->getAbsoluteURL();
            session()->set('destination', $destination);

            return redirect()->to('/login-admin');
        }

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
        if (!session()->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

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
        $id_kategori = $this->request->getPost('id_kategori'); // ambil id_kategori dari input form

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
            'id_kategori' => $id_kategori
        ];

        $model->saveDataArticle($data);

        $redirect_url = site_url('Admin/category/' . $id_kategori); // redirect ke halaman kategori yang sesuai
        echo '<script>
            alert("Selamat! Berhasil Menambah Data Artikel");
            window.location="' . $redirect_url . '"
            </script>';
    }
    public function editArticle($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

        $model = new User_Model();
        $artikel = $model->getArticle($id)->getRow();

        $data = [
            'current_page' => 'edit_data',
            'page' => 'admin/edit_data',
            'artikel' => $artikel,
        ];

        return view('template_admin', $data);
    }

    public function updateArticle()
    {
        $model = new User_Model();

        // ambil data yang dikirim melalui POST
        $id = $this->request->getPost('id');
        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $gambar = $this->request->getFile('gambar');

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
            'gambar' => $newName
        ];

        // panggil fungsi edit dari model dengan parameter data dan id artikel
        $update = $model->editDataArticle($data, $id);

        if ($update) {
            // jika pembaruan berhasil, redirect ke halaman kategori yang sesuai
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
    public function admin_list()
    {
        $session = session();

        if (!$session->get('logged_in') || $session->get('tipe') !== 'superuser') {
            return redirect()->to('/login-admin');
        }

        $adminModel = new Dafmin_Model();
        $admins = $adminModel->findAll();

        $data = [
            'current_page' => 'admin',
            'page' => 'admin/daftar_admin',
            'admins' => $admins,
        ];

        return view('template_admin', $data);
    }
    public function hapus_multiple_admin()
    {
        $adminsToDelete = $this->request->getPost('admins_to_delete');

        if ($adminsToDelete) {
            $adminModel = new Dafmin_Model();
            foreach ($adminsToDelete as $adminId) {
                $adminModel->deleteAdmin($adminId);
            }

            return redirect()->to('/Admin/admin_list')->with('success_message', 'Data admin terpilih berhasil dihapus.');
        }

        return redirect()->to('/Admin/admin_list')->with('error_message', 'Tidak ada data admin yang terpilih untuk dihapus.');
    }
    public function edit_admin()
    {
        $adminId = $this->request->getPost('admin_id');
        $editData = [
            'nama' => $this->request->getPost('edit_nama'),
            'username' => $this->request->getPost('edit_username'),
            'email' => $this->request->getPost('edit_email'),
            'password' => $this->request->getPost('edit_password'),
            'status' => $this->request->getPost('edit_status'),
            'tipe' => $this->request->getPost('edit_tipe'),
        ];

        $adminModel = new Dafmin_Model();
        $adminModel->updateAdminWithLastUpdated($adminId, $editData);

        return redirect()->to('/Admin/admin_list')->with('success_message', 'Data admin berhasil diperbarui.');
    }

    public function toggleAdminStatus($adminId, $newStatus)
    {
        $adminModel = new Dafmin_Model();

        // Pastikan $newStatus hanya bernilai 'active' atau 'inactive'
        if ($newStatus === 'aktif' || $newStatus === 'nonaktif') {
            $adminModel->where('id', $adminId)->set('status', $newStatus)->update();
        } else {
            return redirect()->back()->with('error', 'Nilai status tidak valid.');
        }

        return redirect()->to(site_url('Admin/admin_list'));
    }
}