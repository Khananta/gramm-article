<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Dafmin_Model;
use CodeIgniter\I18n\Time;

class Auth extends Controller
{
    public function processRegistration()
{
    // Dapatkan data yang akan ditambahkan
    $nama = $this->request->getPost('nama');
    $username = $this->request->getPost('username');
    $email = $this->request->getPost('email');

    // Memeriksa apakah alamat email sesuai dengan format yang diinginkan
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !strpos($email, "@gmail.com")) {
        // Jika tidak sesuai, tampilkan pesan kesalahan
        $response = [
            'status' => 'error',
            'message' => 'Data gagal ditambahkan. Email harus memiliki format yang sesuai, contoh: example@gmail.com',
        ];
        return redirect()->to('/adminlist')->with('response', $response);
    }

    // Periksa apakah nama sudah ada dalam database
    $adminModel = new Dafmin_Model();
    $existingAdminNama = $adminModel->where('nama', $nama)->first();

    if ($existingAdminNama) {
        // Nama sudah ada dalam database, tampilkan pesan kesalahan
        $response = [
            'status' => 'error',
            'message' => 'Data gagal ditambahkan. Nama sudah tersedia',
        ];
        return redirect()->to('/adminlist')->with('response', $response);
    }

    // Periksa apakah username sudah ada dalam database
    $existingAdminUsername = $adminModel->where('username', $username)->first();

    if ($existingAdminUsername) {
        // Username sudah ada dalam database, tampilkan pesan kesalahan
        $response = [
            'status' => 'error',
            'message' => 'Data gagal ditambahkan. Username sudah tersedia',
        ];
        return redirect()->to('/adminlist')->with('response', $response);
    }

    // Periksa apakah email sudah ada dalam database
    $existingAdminEmail = $adminModel->where('email', $email)->first();

    if ($existingAdminEmail) {
        // Email sudah ada dalam database, tampilkan pesan kesalahan
        $response = [
            'status' => 'error',
            'message' => 'Data gagal ditambahkan. Email sudah tersedia',
        ];
        return redirect()->to('/adminlist')->with('response', $response);
    }

    // Jika tidak ada data yang sama, simpan data admin baru
    $data = [
        'nama' => $nama,
        'email' => $email,
        'username' => $username,
        'password' => $this->request->getPost('password'),
        'tipe' => $this->request->getPost('tipe'),
        'status' => $this->request->getPost('status'),
        'last_updated' => Time::now()->toLocalizedString('yyyy-MM-dd HH:mm:ss'),
    ];

    $adminModel->insert($data);

    $response = [
        'status' => 'success',
        'message' => 'Data admin berhasil ditambahkan!',
    ];
    return redirect()->to('/adminlist')->with('response', $response);
}



    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $model = new Dafmin_Model();

        $usernameOrEmail = $this->request->getPost('username_or_email');
        $password = $this->request->getPost('password');

        // Check if either field is empty
        if (empty($usernameOrEmail) || empty($password)) {
            $alertMessage = "Data tidak boleh ada yang  kosong!";
            return redirect()->to('login-admin')->with('alert', $alertMessage);
        }

        $user = $model->getUserByUsernameOrEmail($usernameOrEmail);

        if ($user) {
            // User found, now check the password
            if ($user['password'] === $password) {
                $session = session();
                $session->set('logged_in', true);
                $session->set('user_id', $user['id']);
                $session->set('tipe', $user['tipe']);
                $session->set('status', $user['status']);
                $session->set('nama_admin', $user['nama']);

                if ($user['status'] !== 'aktif') {
                    $alertMessage = "Status akun tidak aktif, silahkan hubungi Superuser!";
                    return redirect()->to('login-admin')->with('alert', $alertMessage);
                }

                $pesanSelamatDatang = "Selamat datang, " . $user['nama'] . "!";
                $session->setFlashdata('pesan_selamat_datang', $pesanSelamatDatang);

                $destination = $session->get('destination');
                if ($destination) {
                    return redirect()->to($destination);
                } else {
                    return redirect()->to('/dashboard');
                }
            } else {
                $alertMessage = "Password salah!";
                return redirect()->to('login-admin')->with('alert', $alertMessage);
            }
        } else {
            $alertMessage = "Username atau Email tidak ditemukan!";
            return redirect()->to('login-admin')->with('alert', $alertMessage);
        }
    }



    public function logout()
    {
        $session = session();
        $session->remove(['logged_in', 'user_id']);

        return redirect()->to('login-admin');
    }
}