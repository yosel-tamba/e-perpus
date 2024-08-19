<?php namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table      = 'galeri';
    protected $primaryKey = 'id';
    protected $allowedFields = ['keterangan', 'tanggal', 'gambar'];

}
