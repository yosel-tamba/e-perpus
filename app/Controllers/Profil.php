<?php

namespace App\Controllers;

use App\Models\AboutModel;
use App\Models\AlamatModel;
use App\Models\JamPelayananModel;
use App\Models\KontakModel;

class Profil extends BaseController
{
    protected $aboutModel;
    protected $alamatModel;
    protected $jamPelayananModel;
    protected $kontakModel;

    public function __construct()
    {
        $this->aboutModel = new AboutModel();
        $this->alamatModel = new AlamatModel();
        $this->jamPelayananModel = new JamPelayananModel();
        $this->kontakModel = new KontakModel();
    }

    public function perpus()
    {
        $data['title'] = 'Profil';
        $data['about'] = $this->aboutModel->first();
        $data['alamat'] = $this->alamatModel->first();
        $data['jam_pelayanan'] = $this->jamPelayananModel->first();
        $data['kontak'] = $this->kontakModel->findAll();

        return view('admin/profil', $data);
    }

    public function storeKontak()
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'link' => $this->request->getPost('link')
        ];

        $this->kontakModel->insert($data);
        return redirect()->to('/admin/profil')->with('success', 'Kontak berhasil ditambahkan.');
    }

    public function updateKontak()
    {
        $id = $this->request->getPost('id');
        $data = [
            'nama' => $this->request->getPost('nama'),
            'link' => $this->request->getPost('link')
        ];

        $this->kontakModel->update($id, $data);
        return redirect()->to('/admin/profil')->with('success', 'Kontak berhasil diubah.');
    }

    public function deleteKontak($id)
    {
        $this->kontakModel->delete($id);
        return redirect()->to('/admin/profil')->with('success', 'Kontak berhasil dihapus.');
    }

    public function updateAbout()
    {
        $nama = $this->request->getPost('nama');
        $deskripsi = $this->request->getPost('deskripsi');

        $file = $this->request->getFile('logo');
        $about = $this->aboutModel->first();

        if ($file && $file->isValid()) {
            $newFileName = $file->getName();
            $file->move('img', $newFileName);

            if (file_exists('img/' . $about['logo'])) {
                unlink('img/' . $about['logo']);
            }
        } else {
            $newFileName = $about['logo'];
        }

        $data = [
            'nama' => $nama,
            'deskripsi' => $deskripsi,
            'logo' => $newFileName
        ];

        $this->aboutModel->update($about['id'], $data);

        return redirect()->to(base_url('/admin/profil'))->with('success', 'Data Tentang berhasil diupdate');
    }

    public function updateAlamat()
    {
        if (!$this->validate([
            'alamat' => 'required',
            'link'   => 'required|valid_url',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'alamat' => $this->request->getPost('alamat'),
            'link'   => $this->request->getPost('link'),
        ];

        $this->alamatModel->update(1, $data);

        return redirect()->to('/admin/profil')->with('success', 'Data alamat berhasil diperbarui');
    }

    public function updateJamPelayanan()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'buka' => 'required',
            'tutup' => 'required'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Ambil input data
        $buka = $this->request->getPost('buka');
        $tutup = $this->request->getPost('tutup');

        // Simpan ke database
        $jamPelayananModel = new \App\Models\JamPelayananModel();

        $data = [
            'buka' => $buka,
            'tutup' => $tutup,
        ];

        if ($jamPelayananModel->update(1, $data)) {
            return redirect()->to('/admin/profil')->with('success', 'Jam pelayanan berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui jam pelayanan.');
        }
    }
}
