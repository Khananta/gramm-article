<?php

namespace App\Controllers;

use App\Models\Dafmin_Model;
use App\Models\Kategori_Model;
use App\Models\User_Model;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class Dashboard extends Controller
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

        $totalCategories = count($categories);
        $itemsPerPage = 5;
        $totalPages = ceil($totalCategories / $itemsPerPage);
        $currentpage = $this->request->getGet('halaman-ke') ?? 1;
        $offset = ($currentpage - 1) * $itemsPerPage;
        $categoriesToDisplay = array_slice($categories, $offset, $itemsPerPage);

        $data = [
            'current_page' => 'dashboard',
            'page' => 'admin/dashboard',
            'categories' => $categoriesToDisplay,
            'admin' => $admin,
            'totalPages' => $totalPages,
            'currentPage' => $currentpage
        ];

        return view('template_admin', $data);
    }

    public function addcategory()
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
            'message' => 'Data kategori berhasil ditambahkan!',
        ];
        return redirect()->to('/dashboard')->with('response', $response);
    }
    public function deletecategory()
    {
        $categoriesToDelete = $this->request->getPost('category_to_delete');

        if ($categoriesToDelete) {
            $kategoriModel = new Kategori_Model();
            $userModel = new User_Model();

            foreach ($categoriesToDelete as $kategoriId) {
                $userModel->deleteArticlesByCategoryId($kategoriId);
                $kategoriModel->deleteCategory($kategoriId);
            }

            $response = [
                'status' => 'success',
                'message' => 'Kategori berhasil dihapus beserta artikel terkait.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Tidak ada kategori yang dipilih untuk dihapus.'
            ];
        }

        return $this->response->setJSON($response);
    }
    public function editcategory()
    {
    $kategoriId = $this->request->getPost('kategori_id');
    $editData = [
        'nama_kategori' => $this->request->getPost('edit_nama'),
        'status' => $this->request->getPost('edit_status'),
    ];

    $kategoriModel = new Kategori_Model();
    $kategoriModel->updateKategoriWithLastUpdated($kategoriId, $editData);

    $userModel = new User_Model();
    $userModel->updateStatusByKategori($kategoriId, ['status' => $editData['status']]);

    return redirect()->to('/dashboard');
}
}