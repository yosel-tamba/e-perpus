<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('masuk');
    }

    public function cek_login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validate the input
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Silakan isi semua kolom.');
        }

        // Fetch the user from the database by username
        $userModel = new UsersModel();
        $user = $userModel->where('username', $username)->first();

        // Check if user exists and password is correct
        if ($user && md5($password) === $user['password']) {
            // Store user data in session
            session()->set([
                'id_user' => $user['id_user'],
                'nama_user' => $user['nama_user'],
                'level' => $user['level'],
                'gambar' => $user['gambar'],
                'email' => $user['email'],
                'isLoggedIn' => true
            ]);

            // Redirect based on user role
            if ($user['level'] === '0') {
                return redirect()->to('/admin/dashboard');
            } elseif ($user['level'] === '1') {
                return redirect()->to('/');
            }
        }

        return redirect()->back()->with('errors', 'Username atau Password salah. Masukkan data valid!.');
    }

    public function logout()
    {
        // Hapus data session
        session()->destroy();

        // Redirect ke halaman login
        return redirect()->to('/masuk')->with('success', 'Anda telah berhasil keluar.');
    }
}
