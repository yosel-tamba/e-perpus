<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data['kategori'] = $this->kategoriModel->findAll();
        $data['title'] = 'Kategori';
        return view('admin/kategori', $data);
    }

    public function store()
    {
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ];

        if ($this->kategoriModel->save($data)) {
            return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan kategori.');
        }
    }

    public function update()
    {
        $id = $this->request->getPost('id_kategori');
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ];

        if ($this->kategoriModel->update($id, $data)) {
            return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kategori.');
        }
    }

    public function delete($id)
    {
        if ($this->kategoriModel->delete($id)) {
            return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
