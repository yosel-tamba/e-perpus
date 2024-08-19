<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Admin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is not an admin
        if (session()->get('level') !== '0') {
            // Redirect to home page if not admin
            return redirect()->to('/masuk')->with('errors', 'Silahkan masuk menggunakan aku Admin untuk mengakses halaman itu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action after
    }
}
