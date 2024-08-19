<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $bukuModel;
    protected $usersModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->bukuModel = new BukuModel();
        $this->usersModel = new UsersModel();
    }

    // Menampilkan daftar peminjaman
    public function index()
    {
        $data = [
            'title' => 'Peminjaman',
            'peminjaman' => $this->peminjamanModel->getPeminjamanWithDetails(),
            'buku' => $this->bukuModel->findAll(),
            'users' => $this->usersModel->where('level !=', '0')->findAll(),
        ];

        return view('admin/peminjaman', $data);
    }

    // Menyimpan data peminjaman
    public function store()
    {
        $this->peminjamanModel->insert([
            'id_user' => $this->request->getPost('id_user'),
            'id_buku' => $this->request->getPost('id_buku'),
            'tgl_pinjam' => $this->request->getPost('tgl_pinjam'),
            'tgl_kembali' => $this->request->getPost('tgl_kembali'),
            'status' => ($this->request->getPost('tgl_kembali') ? 'dikembalikan' : 'dipinjamkan')
        ]);

        return redirect()->to('/admin/peminjaman')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    // Mengupdate data peminjaman
    public function update()
    {
        $id = $this->request->getPost('id_peminjaman');

        $this->peminjamanModel->update($id, [
            'id_user' => $this->request->getPost('id_user'),
            'id_buku' => $this->request->getPost('id_buku'),
            'tgl_pinjam' => $this->request->getPost('tgl_pinjam'),
            'tgl_kembali' => $this->request->getPost('tgl_kembali'),
            'status' => ($this->request->getPost('tgl_kembali') ? 'dikembalikan' : 'dipinjamkan')
        ]);

        return redirect()->to('/admin/peminjaman')->with('success', 'Peminjaman berhasil diubah.');
    }

    // Menghapus data peminjaman
    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->to('/admin/peminjaman')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
