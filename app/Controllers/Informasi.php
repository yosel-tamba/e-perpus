<?php

namespace App\Controllers;

use App\Models\InformasiModel;

class Informasi extends BaseController
{
    protected $informasiModel;

    public function __construct()
    {
        $this->informasiModel = new InformasiModel();
    }

    public function index()
    {
        $data['title'] = 'Informasi';
        $data['informasi'] = $this->informasiModel->findAll();
        return view('admin/informasi', $data);
    }

    public function store()
    {
        $this->informasiModel->save([
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi')
        ]);

        return redirect()->to('/admin/informasi')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function update()
    {
        $this->informasiModel->save([
            'id' => $this->request->getPost('id'),
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi')
        ]);

        return redirect()->to('/admin/informasi')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->informasiModel->delete($id);
        return redirect()->to('/admin/informasi')->with('success', 'Informasi berhasil dihapus.');
    }
}
