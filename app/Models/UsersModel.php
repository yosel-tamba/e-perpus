<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    // Define the fields that can be inserted or updated
    protected $allowedFields = ['nis', 'username', 'password', 'email', 'nama_user', 'gambar', 'level'];

    // Function to get users with biodata
    public function getUsersWithBiodata()
    {
        return $this->select('users.*, biodata.tgl_lahir, biodata.tlp, biodata.kelamin, biodata.alamat')
            ->join('biodata', 'biodata.id_user = users.id_user')
            ->findAll();
    }

    // Function to get a single user with biodata
    public function getUserWithBiodata($id_user)
    {
        return $this->select('users.*, biodata.tgl_lahir, biodata.tlp, biodata.kelamin, biodata.alamat')
            ->join('biodata', 'biodata.id_user = users.id_user')
            ->where('users.id_user', $id_user)
            ->first();
    }
}
