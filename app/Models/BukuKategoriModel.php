<?php namespace App\Models;

use CodeIgniter\Model;

class BukuKategoriModel extends Model
{
    protected $table = 'buku_kategori';
    protected $primaryKey = 'id_buku_kategori';
    protected $allowedFields = ['id_buku', 'id_kategori'];

}
