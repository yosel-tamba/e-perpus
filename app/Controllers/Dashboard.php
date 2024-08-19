<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new PeminjamanModel();
        $data['peminjaman'] = $model->getPeminjamanWithDetails();
        $data['title'] = 'Dashboard';

        return view('admin/dashboard', $data);
    }
}
