<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/masuk', 'Auth::index');
$routes->post('/masuk', 'Auth::cek_login');
$routes->get('/logout', 'Auth::logout');

$routes->group('', ['filter' => 'isLoggedIn'], function ($routes) {
    // ADMIN
    $routes->group('', ['filter' => 'admin'], function ($routes) {
        $routes->get('/admin/dashboard', 'Dashboard::index');

        $routes->get('/admin/buku', 'Buku::index');
        $routes->post('/admin/buku/store', 'Buku::tambah');
        $routes->put('/admin/buku/update', 'Buku::ubah');
        $routes->delete('/admin/buku/delete', 'Buku::hapus');

        $routes->get('/admin/kategori', 'Kategori::index');
        $routes->post('/admin/kategori/store', 'Kategori::store');
        $routes->post('/admin/kategori/update', 'Kategori::update');
        $routes->get('/admin/kategori/delete/(:num)', 'Kategori::delete/$1');

        $routes->get('/admin/peminjaman', 'Peminjaman::index');
        $routes->post('/admin/peminjaman/store', 'Peminjaman::store');
        $routes->post('/admin/peminjaman/update', 'Peminjaman::update');
        $routes->get('/admin/peminjaman/delete/(:num)', 'Peminjaman::delete/$1');

        $routes->get('/admin/users', 'Users::index');
        $routes->post('/admin/users/store', 'Users::store');
        $routes->post('/admin/users/update', 'Users::update');
        $routes->get('/admin/users/delete/(:num)', 'Users::delete/$1');

        $routes->get('/admin/news', 'News::index');
        $routes->post('/admin/news/store', 'News::store');
        $routes->post('/admin/news/update', 'News::update');
        $routes->get('/admin/news/delete/(:num)', 'News::delete/$1');

        $routes->get('/admin/gallery', 'Gallery::index');
        $routes->post('/admin/gallery/store', 'Gallery::store');
        $routes->post('/admin/gallery/update', 'Gallery::update');
        $routes->get('/admin/gallery/delete/(:num)', 'Gallery::delete/$1');

        $routes->get('/admin/informasi', 'Informasi::index');
        $routes->post('/admin/informasi/store', 'Informasi::store');
        $routes->post('/admin/informasi/update', 'Informasi::update');
        $routes->get('/admin/informasi/delete/(:num)', 'Informasi::delete/$1');

        $routes->get('/admin/profil', 'Profil::perpus');

        $routes->post('/admin/kontak/store', 'Profil::storeKontak');
        $routes->post('/admin/kontak/update', 'Profil::updateKontak');
        $routes->get('/admin/kontak/delete/(:num)', 'Profil::deleteKontak/$1');

        $routes->post('/admin/about/update', 'Profil::updateAbout');
        $routes->post('/admin/alamat/update', 'Profil::updateAlamat');
        $routes->post('/admin/jam-pelayanan/update', 'Profil::updateJamPelayanan');
    });
    // END ADMIN
});
