<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\BukuKategoriModel;

class Buku extends BaseController
{
    protected $bukuModel;
    protected $kategoriModel;
    protected $bukuKategoriModel;

    // Constructor untuk inisialisasi model
    public function __construct()
    {
        $this->bukuModel = new BukuModel();
        $this->kategoriModel = new KategoriModel();
        $this->bukuKategoriModel  = new BukuKategoriModel();
    }

    public function index()
    {
        $data['buku'] = $this->bukuModel->getBukuWithKategori();
        $data['kategori'] = $this->kategoriModel->orderBy('nama_kategori', 'asc')->findAll();
        $data['title'] = 'Buku';

        return view('admin/buku', $data);
    }

    public function tambah()
    {
        // Validation rules including for category selection
        $validation = $this->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|numeric',
            'sinopsis' => 'required',
            'stok' => 'required|numeric',
            'gambar' => 'uploaded[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,2048]',
            'file' => 'mime_in[file,application/pdf]',
            'kategori' => 'required' // Assuming at least one category must be selected
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $file = $this->request->getFile('file');

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $gambarName = $gambar->getClientName() . '_' . $gambar->getRandomName();
            $gambar->move(FCPATH . 'img/cover/', $gambarName);
        } else {
            $gambarName = 'default.jpg';
        }

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getClientName() . '_' . $file->getRandomName();
            $file->move(FCPATH . 'img/buku/', $fileName);
        } else {
            $fileName = null;
        }

        // Insert book data
        $bookData = [
            'judul' => $this->request->getPost('judul'),
            'penulis' => $this->request->getPost('penulis'),
            'penerbit' => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'sinopsis' => $this->request->getPost('sinopsis'),
            'stok' => $this->request->getPost('stok'),
            'gambar' => $gambarName,
            'file' => $fileName,
            'tgl_add' => date('Y-m-d H:i:s'),
        ];

        // Insert book and get the ID
        $bookId = $this->bukuModel->insert($bookData, true); // Assuming 'true' returns the ID

        // Insert categories
        $kategoriIds = $this->request->getPost('kategori'); // Array of selected category IDs
        if ($kategoriIds) {
            foreach ($kategoriIds as $kategoriId) {
                $this->bukuKategoriModel->insert([
                    'id_buku' => $bookId,
                    'id_kategori' => $kategoriId
                ]);
            }
        }

        return redirect()->to('/admin/buku')->with('success', 'Buku berhasil ditambahkan');
    }


    public function ubah()
    {
        $id = $this->request->getPost('id_buku');
        $gambar = $this->request->getFile('gambar');
        $file = $this->request->getFile('file');

        // Ambil kategori dari input
        $kategori = $this->request->getPost('kategori');
        // Jika tidak ada kategori yang dipilih, set kategori menjadi array kosong
        $kategori = $kategori ? $kategori : [];

        $data = [
            'judul' => $this->request->getPost('judul'),
            'penulis' => $this->request->getPost('penulis'),
            'penerbit' => $this->request->getPost('penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'sinopsis' => $this->request->getPost('sinopsis'),
            'skor_total' => ($this->request->getPost('skor_total') == "" ? null : $this->request->getPost('skor_total')),
            'stok' => $this->request->getPost('stok'),
        ];

        $currentBuku = $this->bukuModel->find($id);
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $currentImagePath = FCPATH . 'img/cover/' . $currentBuku['gambar'];

            if ($currentBuku['gambar'] != 'default.jpg' && file_exists($currentImagePath)) {
                unlink($currentImagePath);
            }

            $gambarName = $gambar->getClientName() . '_' . $gambar->getRandomName();
            $gambar->move(FCPATH . 'img/cover/', $gambarName);
            $data['gambar'] = $gambarName;
        } else {
            $data['gambar'] = $currentBuku['gambar'];
        }

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $currentFilePath = FCPATH . 'img/buku/' . $currentBuku['file'];

            if ($currentBuku['file'] && file_exists($currentFilePath)) {
                unlink($currentFilePath);
            }

            $fileName = $file->getClientName() . '_' . $file->getRandomName();
            $file->move(FCPATH . 'img/buku/', $fileName);
            $data['file'] = $fileName;
        } else {
            $data['file'] = $currentBuku['file'];
        }

        // Update data buku
        $this->bukuModel->update($id, $data);

        // Update kategori buku
        // Hapus kategori lama
        $this->bukuKategoriModel->where('id_buku', $id)->delete();

        // Tambah kategori baru
        foreach ($kategori as $id_kategori) {
            $this->bukuKategoriModel->insert([
                'id_buku' => $id,
                'id_kategori' => $id_kategori
            ]);
        }

        return redirect()->to('/admin/buku')->with('success', 'Buku berhasil diperbarui');
    }

    public function hapus()
    {
        $id_buku = $this->request->getPost('id_buku');
        $buku = $this->bukuModel->find($id_buku);

        if ($buku) {
            $this->bukuModel->delete($id_buku);

            if ($buku['gambar'] != 'default.jpg' && file_exists(FCPATH . 'img/cover/' . $buku['gambar'])) {
                unlink(FCPATH . 'img/cover/' . $buku['gambar']);
            }
            if (!empty($buku['file']) && file_exists(FCPATH . 'img/buku/' . $buku['file'])) {
                unlink(FCPATH . 'img/buku/' . $buku['file']);
            }
            return redirect()->to('/admin/buku')->with('success', 'Buku berhasil dihapus.');
        }
        return redirect()->to('/admin/buku')->with('error', 'Buku tidak ditemukan.');
    }
}
