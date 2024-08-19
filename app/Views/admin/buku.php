<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Buku</h6>
        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal">
            <i class="fas fa-plus"></i> Tambah Buku
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped nowrap" id="dataTable">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Skor</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($buku as $item): ?>
                        <tr>
                            <td class="align-middle">
                                <img src="<?= base_url('img/cover/' . $item['gambar']) ?>" alt="Cover Image" width="100" class="rounded">
                            </td>
                            <td class="align-middle text-wrap"><?= esc($item['judul']) ?></td>
                            <td class="align-middle"><?= esc($item['penulis']) ?></td>
                            <td class="align-middle text-wrap"><?= esc($item['penerbit']) ?></td>
                            <td class="align-middle"><?= esc($item['tahun_terbit']) ?></td>
                            <td class="align-middle"><?= esc($item['skor_total'] == null ? 'Belum Ada Skor' : $item['skor_total']) ?></td>
                            <td class="align-middle"><?= esc($item['stok']) ?></td>
                            <td class="align-middle text-wrap">
                                <?php
                                $categories = explode(',', $item['nama_kategori']);
                                sort($categories);
                                foreach ($categories as $category): ?>
                                    <span class="badge badge-primary"><?= esc($category) ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td class="align-middle">
                                <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= esc($item['id_buku']) ?>" title="Ubah">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= esc($item['id_buku']) ?>" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Skor</th>
                        <th>Stok</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModal">Tambah Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/admin/buku/store') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <!-- Left side (Form inputs) -->
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="form-group">
                                <label for="penulis">Penulis</label>
                                <input type="text" class="form-control" id="penulis" name="penulis" required>
                            </div>
                            <div class="form-group">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                            </div>
                            <div class="d-flex row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="tahun_terbit">Tahun Terbit</label>
                                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input type="number" class="form-control" id="stok" name="stok" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sinopsis">Sinopsis</label>
                                <textarea class="form-control" id="sinopsis" name="sinopsis" rows="10" required></textarea>
                            </div>
                        </div>
                        <!-- Right side (Image and file inputs) -->
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Sampul Buku</label>
                                <div class="text-center">
                                    <div class="mb-2">
                                        <img id="previewImage" src="<?= base_url('img/cover/default.jpg'); ?>" alt="Image Preview" style="width: 100%;" class="rounded">
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('gambar').click();">Pilih Gambar</button>
                                    <input type="file" class="d-none" id="gambar" name="gambar" accept=".jpg,.jpeg,.png" onchange="previewImageAdd(event)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="file">File Buku</label>
                                <input type="file" class="form-control-file" id="file" name="file" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <!-- Kategori Checkbox -->
                    <div class="form-group mt-3">
                        <label for="kategori">Kategori</label>
                        <div class="row">
                            <?php foreach ($kategori as $kat): ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kategori[]" id="kategori<?= $kat['id_kategori']; ?>" value="<?= $kat['id_kategori']; ?>">
                                        <label class="form-check-label" for="kategori<?= $kat['id_kategori']; ?>">
                                            <?= esc($kat['nama_kategori']); ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImageAdd(event) {
        var reader = new FileReader();
        var output = document.getElementById('previewImage');

        reader.onload = function() {
            output.src = reader.result;
            output.style.display = 'block';
        };

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
            output.style.display = 'none';
        }
    }
</script>

<!-- Modal Ubah -->
<?php foreach ($buku as $item): ?>
    <div class="modal fade" id="editModal<?= esc($item['id_buku']) ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= esc($item['id_buku']) ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= esc($item['id_buku']) ?>">Ubah Data Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('/admin/buku/update') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id_buku" value="<?= esc($item['id_buku']) ?>">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="judul<?= esc($item['id_buku']) ?>">Judul</label>
                                    <input type="text" class="form-control" id="judul<?= esc($item['id_buku']) ?>" name="judul" value="<?= esc($item['judul']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="penulis<?= esc($item['id_buku']) ?>">Penulis</label>
                                    <input type="text" class="form-control" id="penulis<?= esc($item['id_buku']) ?>" name="penulis" value="<?= esc($item['penulis']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="penerbit<?= esc($item['id_buku']) ?>">Penerbit</label>
                                    <input type="text" class="form-control" id="penerbit<?= esc($item['id_buku']) ?>" name="penerbit" value="<?= esc($item['penerbit']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="tahun_terbit<?= esc($item['id_buku']) ?>">Tahun Terbit</label>
                                    <input type="number" class="form-control" id="tahun_terbit<?= esc($item['id_buku']) ?>" name="tahun_terbit" value="<?= esc($item['tahun_terbit']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="sinopsis<?= esc($item['id_buku']) ?>">Sinopsis</label>
                                    <textarea class="form-control" id="sinopsis<?= esc($item['id_buku']) ?>" name="sinopsis" rows="7" required><?= esc($item['sinopsis']) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="skor_total<?= esc($item['id_buku']) ?>">Skor Total</label>
                                    <input type="number" step="0.1" class="form-control" id="skor_total<?= esc($item['id_buku']) ?>" name="skor_total" value="<?= esc($item['skor_total']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="stok<?= esc($item['id_buku']) ?>">Stok</label>
                                    <input type="number" class="form-control" id="stok<?= esc($item['id_buku']) ?>" name="stok" value="<?= esc($item['stok']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <!-- Sampul Buku -->
                                <div class="form-group">
                                    <label>Sampul Buku</label>
                                    <div class="text-center form-group">
                                        <div class="mb-2">
                                            <img id="currentImage<?= esc($item['id_buku']) ?>" src="<?= base_url('img/cover/' . $item['gambar']) ?>" alt="Cover Image" style="width: 100%;" class="rounded">
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="document.getElementById('gambar<?= esc($item['id_buku']) ?>').click();">Pilih Gambar</button>
                                        <input type="file" class="d-none" id="gambar<?= esc($item['id_buku']) ?>" name="gambar" accept=".jpg,.jpeg,.png" onchange="previewImage(event, 'currentImage<?= esc($item['id_buku']) ?>')">
                                        <small class="form-text text-danger">Biarkan jika tidak ingin mengubah gambar.</small>
                                    </div>

                                    <!-- File Buku -->
                                    <div class="form-group">
                                        <label for="file<?= esc($item['id_buku']) ?>">File Buku</label>
                                        <div class="mb-2">
                                            <a href="#" class="btn btn-info" data-dismiss="modal" data-toggle="modal" data-target="#previewFileModal<?= esc($item['id_buku']) ?>">Lihat File</a>
                                        </div>
                                        <input type="file" class="form-control-file" id="file<?= esc($item['id_buku']) ?>" name="file" accept="application/pdf">
                                        <small class="form-text text-danger">Biarkan kosong jika tidak ingin mengubah file tambahan.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kategori (Pindah ke luar row) -->
                        <div class="form-group mt-3">
                            <label for="kategori">Kategori</label>
                            <div class="row">
                                <?php
                                // Mengurutkan kategori berdasarkan nama
                                usort($kategori, function ($a, $b) {
                                    return strcmp($a['nama_kategori'], $b['nama_kategori']);
                                });
                                ?>
                                <?php foreach ($kategori as $kat): ?>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kategori[]" id="kategoriEdit<?= $kat['id_kategori']; ?>" value="<?= esc($kat['id_kategori']); ?>" <?= in_array($kat['id_kategori'], explode(',', $item['kategori'])) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="kategoriEdit<?= $kat['id_kategori']; ?>">
                                                <?= esc($kat['nama_kategori']); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview File Modal -->
    <div class="modal fade" id="previewFileModal<?= esc($item['id_buku']) ?>" tabindex="-1" role="dialog" aria-labelledby="previewFileModalLabel<?= esc($item['id_buku']) ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview File Buku: <?= esc($item['judul']) ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <embed src="<?= base_url('img/buku/' . $item['file']) ?>" width="100%" height="500px" type="application/pdf">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#editModal<?= esc($item['id_buku']) ?>">Kembali</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script>
    function previewImage(event, imgId) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(imgId);
            output.src = reader.result;
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>

<!-- Modal Delete -->
<?php if (!empty($buku)): ?>
    <?php foreach ($buku as $item): ?>
        <div class="modal fade" id="deleteModal<?= esc($item['id_buku']) ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel<?= esc($item['id_buku']) ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel<?= esc($item['id_buku']) ?>">Hapus Buku</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <!-- Display the book cover image -->
                        <img src="<?= base_url('img/cover/' . $item['gambar']) ?>" alt="Cover Image" width="150" class="rounded mb-3">

                        <!-- Confirmation text -->
                        <p>Apakah Anda yakin ingin menghapus buku <strong><?= esc($item['judul']) ?></strong>? Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="<?= base_url('/admin/buku/delete') ?>" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id_buku" value="<?= $item['id_buku']; ?>">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>