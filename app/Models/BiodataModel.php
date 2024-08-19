<?php

namespace App\Models;

use CodeIgniter\Model;

class BiodataModel extends Model
{
    protected $table = 'biodata';
    protected $primaryKey = 'id_biodata';
    protected $allowedFields = ['id_user', 'tgl_lahir', 'tlp', 'kelamin', 'alamat'];
}
