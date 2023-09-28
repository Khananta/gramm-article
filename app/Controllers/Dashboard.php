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

        $searchKeyword = $this->request->getGet('search');

        if (!$session->get('logged_in')) {
            return redirect()->to('/login-admin');
        }

        $datmin = new Dafmin_Model();
        $usermodel = new User_Model();
        $kategoriModel = new Kategori_Model();
        $categories = $kategoriModel->searchCategories($searchKeyword);
        $userId = $session->get('user_id');
        $admin = $datmin->find($userId);
        $count = $usermodel->countAll();

        $articleCounts = [];
        foreach ($categories as $category) {
            $categoryId = $category['id_kategori'];
            $articleCounts[$categoryId] = $kategoriModel->countArticlesInCategory($categoryId);
        }

        // Check if the admin status is 'nonaktif', and if so, logout and redirect
        if ($admin['status'] === 'nonaktif') {
            // Logout the admin
            $session->destroy();

            return redirect()->to('/login-admin')->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        $totalCategories = count($categories); // Count the total number of categories
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
            'count' => $count,
            'totalPages' => $totalPages,
            'currentPage' => $currentpage,
            'totalCategories' => $totalCategories,
            'articleCounts' => $articleCounts,
            // Add this line to pass the articleCounts to the view
        ];


        $userRole = $session->get('tipe');

        if ($userRole === 'superuser') {
            return view('template_admin', $data);
        } elseif ($userRole === 'admin') {
            return view('admin_2', $data);
        } else {
            return redirect()->to('/dashboard');
        }
    }


    public function addcategory()
    {
        $model = new Kategori_Model();

        // Check if the category name already exists
        $existingCategory = $model->where('nama_kategori', $this->request->getPost('nama_kategori'))->first();

        if ($existingCategory) {
            // Display SweetAlert error message
            $response = [
                'status' => 'error',
                'message' => 'Nama kategori gagal ditambahkan karena data sudah ada!',
            ];
            return redirect()->to('/dashboard')->with('response', $response);
        }

        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'status' => $this->request->getPost('status'),
            'last_updated' => Time::now()->toLocalizedString('yyyy-MM-dd HH:mm:ss'),
        ];

        $model->insert($data);

        // Display SweetAlert success message
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

        // Check if the category with the same name already exists, excluding the current category being edited
        $existingCategory = $kategoriModel->where('nama_kategori', $editData['nama_kategori'])
            ->where('id_kategori !=', $kategoriId)
            ->first();

        if ($existingCategory) {
            // Display SweetAlert error message for category name conflict
            $response = [
                'status' => 'error',
                'message' => 'Nama kategori sudah ada dalam database!',
            ];
        } else {
            // Attempt to update the category
            $updated = $kategoriModel->updateKategoriWithLastUpdated($kategoriId, $editData);

            if ($updated) {
                // Category successfully updated, display success message
                $response = [
                    'status' => 'success',
                    'message' => 'Data kategori berhasil diperbarui!',
                ];
            } else {
                // Failed to update the category, display error message
                $response = [
                    'status' => 'error',
                    'message' => 'Gagal memperbarui kategori. Silakan coba lagi.',
                ];
            }
        }

        // Return the response as JSON
        return $this->response->setJSON($response);
    }


}