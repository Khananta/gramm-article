<?php

namespace App\Controllers;

use App\Models\Dafmin_Model;
use CodeIgniter\Controller;

class Admin extends Controller
{
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

            $response = [
                'status' => 'success',
                'message' => 'Admin berhasil dihapus.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Gagal menghapus data.'
            ];
        }

        return $this->response->setJSON($response);
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

    // Periksa apakah nama sudah ada dalam database selain admin yang sedang diedit
    $existingAdminNama = $adminModel->where('nama', $editData['nama'])->where('id !=', $adminId)->first();

    if ($existingAdminNama) {
        // Nama sudah ada dalam database, tampilkan pesan kesalahan
        $response = [
            'status' => 'error',
            'message' => 'Data gagal diperbarui. Nama sudah tersedia',
        ];
        return redirect()->to('/adminlist')->with('response', $response);
    }

    // Periksa apakah username sudah ada dalam database selain admin yang sedang diedit
    $existingAdminUsername = $adminModel->where('username', $editData['username'])->where('id !=', $adminId)->first();

    if ($existingAdminUsername) {
        // Username sudah ada dalam database, tampilkan pesan kesalahan
        $response = [
            'status' => 'error',
            'message' => 'Data gagal diperbarui. Username sudah tersedia',
        ];
        return redirect()->to('/adminlist')->with('response', $response);
    }

    // Periksa apakah email sudah ada dalam database selain admin yang sedang diedit
    $existingAdminEmail = $adminModel->where('email', $editData['email'])->where('id !=', $adminId)->first();

    if ($existingAdminEmail) {
        // Email sudah ada dalam database, tampilkan pesan kesalahan
        $response = [
            'status' => 'error',
            'message' => 'Data gagal diperbarui. Email sudah tersedia',
        ];
        return redirect()->to('/adminlist')->with('response', $response);
    }

    // Jika tidak ada data yang sama, update data admin
    $adminModel->updateAdminWithLastUpdated($adminId, $editData);

    // Tampilkan SweetAlert data berhasil diedit
    $response = [
        'status' => 'success',
        'message' => 'Data admin berhasil diperbarui!',
    ];
    return redirect()->to('/adminlist')->with('response', $response);
}


}