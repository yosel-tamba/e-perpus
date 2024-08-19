<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    protected $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }

    public function index()
    {
        $data['title'] = 'News';
        $data['news'] = $this->newsModel->findAll();
        return view('admin/news', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        // Validasi input
        $validation->setRules([
            'judul' => 'required|min_length[3]',
            'isi' => 'required',
            'tanggal' => 'required|valid_date',
            'gambar' => 'uploaded[gambar]|max_size[gambar,5120]|is_image[gambar]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('gambar');
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'img/news', $newName);

        $this->newsModel->save([
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'tanggal' => $this->request->getPost('tanggal'),
            'gambar' => $newName
        ]);

        return redirect()->to('/admin/news')->with('success', 'News added successfully');
    }

    public function update()
    {
        $validation = \Config\Services::validation();

        // Validasi input
        $validation->setRules([
            'id' => 'required|is_natural_no_zero',
            'judul' => 'required|min_length[3]',
            'isi' => 'required',
            'tanggal' => 'required|valid_date',
            'gambar' => 'mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,5120]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $id = $this->request->getPost('id');
        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'tanggal' => $this->request->getPost('tanggal')
        ];

        $file = $this->request->getFile('gambar');
        if ($file->isValid()) {
            $oldImage = $this->newsModel->find($id)['gambar'];
            if ($oldImage && file_exists(FCPATH . 'img/news/' . $oldImage) && $oldImage != 'default.png') {
                unlink(FCPATH . 'img/news/' . $oldImage);
            }
            
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'img/news', $newName);
            $data['gambar'] = $newName;
        }

        $this->newsModel->update($id, $data);

        return redirect()->to('/admin/news')->with('success', 'News updated successfully');
    }

    public function delete($id)
    {
        $news = $this->newsModel->find($id);
        if ($news) {
            $gambar = $news['gambar'];
            if ($gambar && file_exists(FCPATH . 'img/news/' . $gambar) && $gambar != 'default.png') {
                unlink(FCPATH . 'img/news/' . $gambar);
            }
            $this->newsModel->delete($id);
        }

        return redirect()->to('/admin/news')->with('success', 'News deleted successfully');
    }
}
