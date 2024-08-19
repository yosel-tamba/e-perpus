<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    public function index()
    {
        $usersModel = new UsersModel();
        $data['title'] = 'Users';
        $data['users'] = $usersModel->getUsersWithBiodata();

        // Mengembalikan tampilan dengan data user
        return view('admin/users', $data);
    }

    public function store()
    {
        $usersModel = new UsersModel();

        // Validasi input
        if (!$this->validate([
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
            'nama_user' => 'required',
            'level' => 'required',
        ])) {
            // Jika validasi gagal, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data user ke database
        $usersModel->save([
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_user' => $this->request->getPost('nama_user'),
            'level'     => $this->request->getPost('level'),
            'gambar'    => $this->request->getPost('gambar')
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan.');
    }

    public function update()
    {
        $usersModel = new UsersModel();

        // Validasi input
        if (!$this->validate([
            'id_user'  => 'required',
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email',
            'nama_user' => 'required',
            'level'    => 'required',
        ])) {
            // Jika validasi gagal, kembalikan dengan pesan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data user di database
        $id_user = $this->request->getPost('id_user');
        $data = [
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'nama_user' => $this->request->getPost('nama_user'),
            'level'     => $this->request->getPost('level'),
            'gambar'    => $this->request->getPost('gambar')
        ];

        // Cek jika password diupdate
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $usersModel->update($id_user, $data);

        return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
    }

    public function delete($id_user)
    {
        $usersModel = new UsersModel();

        // Hapus user dari database
        $usersModel->delete($id_user);

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
    }
}
