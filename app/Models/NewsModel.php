<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';

    protected $allowedFields = ['judul', 'isi', 'tanggal', 'gambar'];
    protected $useTimestamps = false;
}
