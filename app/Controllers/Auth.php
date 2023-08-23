<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Dafmin_Model;
use CodeIgniter\I18n\Time;

class Auth extends Controller
{
    public function processRegistration()
    {
        $model = new Dafmin_Model();

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'tipe' => $this->request->getPost('tipe'),
            'status' => $this->request->getPost('status'),
            'last_updated' => Time::now()->toLocalizedString('yyyy-MM-dd HH:mm:ss'),
        ];

        // Validasi data jika diperlukan

        // Simpan data pengguna ke database
        $model->insert($data);

        // Redirect ke halaman login atau halaman lain yang sesuai
        return redirect()->to('/Admin/admin_list');
    }

    public function index()
    {
        return view('login');
    }
    public function login()
    {
        $model = new Dafmin_Model();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->getUserByUsername($username);

        if ($user && $user['password'] === $password) {
            // Set data sesi
            $session = session();
            $session->set('logged_in', true);
            $session->set('user_id', $user['id']);
            $session->set('tipe', $user['tipe']);
            $session->set('status', $user['status']);

            // Check status before redirecting
            if ($user['status'] !== 'aktif') {
                return redirect()->to('login-admin');
            }

            // Redirect ke halaman tujuan atau dashboard
            $destination = $session->get('destination');
            if ($destination) {
                return redirect()->to($destination);
            } else {
                return redirect()->to('Admin/dashboard');
            }
        } else {
            return redirect()->to('login-admin');
        }
    }

    public function logout()
    {
        // Hapus data sesi
        $session = session();
        $session->remove(['logged_in', 'user_id']);

        return redirect()->to('login-admin');
    }
}