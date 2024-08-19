<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $allowedFields = [
        'id_peminjaman',
        'id_user',
        'id_buku',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
    ];

    protected $useTimestamps = false;

    public function getPeminjamanWithDetails()
    {
        return $this->db->table($this->table)
            ->select('peminjaman.*, users.nama_user AS nama_user, buku.judul AS nama_buku')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->orderBy('peminjaman.tgl_kembali', 'DESC')
            ->orderBy('peminjaman.tgl_pinjam', 'DESC')
            ->get()
            ->getResultArray();
    }
}
