<?php namespace App\Models;

use CodeIgniter\Model;

class InformasiModel extends Model
{
    protected $table = 'informasi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'isi'];
}
