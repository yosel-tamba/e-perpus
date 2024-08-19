<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    protected $allowedFields = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'sinopsis', 'stok', 'gambar', 'file', 'tgl_add', 'skor_total'];

    public function getBukuWithKategori()
{
    return $this->select('buku.*, GROUP_CONCAT(kategori.id_kategori) as kategori, GROUP_CONCAT(kategori.nama_kategori) as nama_kategori')
                ->join('buku_kategori', 'buku_kategori.id_buku = buku.id_buku', 'left')
                ->join('kategori', 'buku_kategori.id_kategori = kategori.id_kategori', 'left')
                ->groupBy('buku.id_buku')
                ->findAll();
}

}

