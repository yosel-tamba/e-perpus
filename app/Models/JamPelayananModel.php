<?php namespace App\Models;

use CodeIgniter\Model;

class JamPelayananModel extends Model
{
    protected $table = 'jam_pelayanan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['buka', 'tutup'];
}
