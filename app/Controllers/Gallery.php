<?php

namespace App\Controllers;

use App\Models\GalleryModel;

class Gallery extends BaseController
{
    protected $galleryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
    }

    public function index()
    {
        $data['title'] = 'Gallery';
        $data['gallery'] = $this->galleryModel->findAll();
        return view('admin/gallery', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'keterangan' => 'required',
            'gambar' => 'uploaded[gambar]|max_size[gambar,5120]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid()) {
            $fileName = $file->getRandomName();
            $file->move('img/galeri', $fileName);
        } else {
            $fileName = 'default.png'; // Default image
        }

        $this->galleryModel->save([
            'keterangan' => $this->request->getPost('keterangan'),
            'gambar' => $fileName,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/gallery')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $galleryItem = $this->galleryModel->find($id);

        $validation = \Config\Services::validation();

        $validation->setRules([
            'keterangan' => 'required',
            'gambar' => 'max_size[gambar,5120]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle image upload
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid()) {
            // Generate a random name for the new image
            $fileName = $file->getRandomName();
            $file->move('img/galeri', $fileName);

            // Check if the old image exists and is not the default image, then delete it
            if ($galleryItem['gambar'] != 'default.png' && file_exists('img/galeri/' . $galleryItem['gambar'])) {
                unlink('img/galeri/' . $galleryItem['gambar']);
            }
        } else {
            // If no new image is uploaded, keep the old image
            $fileName = $galleryItem['gambar'];
        }

        $this->galleryModel->update($id, [
            'keterangan' => $this->request->getPost('keterangan'),
            'gambar' => $fileName,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/gallery')->with('success', 'Galeri berhasil diubah.');
    }

    public function delete($id)
    {
        $galleryItem = $this->galleryModel->find($id);

        // Check if the image exists and is not the default image, then delete it
        if ($galleryItem['gambar'] != 'default.png' && file_exists('img/galeri/' . $galleryItem['gambar'])) {
            unlink('img/galeri/' . $galleryItem['gambar']);
        }

        $this->galleryModel->delete($id);

        return redirect()->to('/admin/gallery')->with('success', 'Galeri berhasil dihapus.');
    }
}
