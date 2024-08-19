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
<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <!-- About Card -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Tentang</h6>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubahAboutModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="pr-5">
                                <h5 class="mt-0"><?= esc($about['nama']) ?></h5>
                                <p><?= esc($about['deskripsi']) ?></p>
                            </div>
                            <img src="<?= base_url('img/' . esc($about['logo'])) ?>" alt="Logo" width="150">
                        </div>
                    </div>
                    <!-- Modal Ubah About -->
                    <div class="modal fade" id="ubahAboutModal" tabindex="-1" aria-labelledby="ubahAboutModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="ubahAboutModalLabel">Ubah Tentang <?= esc($about['nama']) ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('admin/about/update') ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Logo Section -->
                                            <div class="col-md-4 text-center">
                                                <label for="logo">Logo</label>
                                                <div class="form-group">
                                                    <div class="mt-3">
                                                        <img id="imagePreview" src="<?= base_url('img/' . esc($about['logo'])) ?>" alt="Logo Preview" class="img-fluid" width="150">
                                                    </div>
                                                    <button type="button" class="btn btn-primary mt-3" onclick="document.getElementById('logo').click();">Pilih Logo</button>
                                                    <input type="file" class="form-control-file d-none" id="logo" name="logo" onchange="previewImage(event)">
                                                    <small class="form-text text-danger">Biarkan jika tidak ingin mengubah gambar.</small>
                                                </div>
                                            </div>

                                            <!-- Nama dan Deskripsi Section -->
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="nama">Nama</label>
                                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= esc($about['nama']) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="deskripsi">Deskripsi</label>
                                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="10" required><?= esc($about['deskripsi']) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">Ubah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        function previewImage(event) {
                            var imagePreview = document.getElementById('imagePreview');
                            var reader = new FileReader();
                            reader.onload = function() {
                                imagePreview.src = reader.result;
                            }
                            reader.readAsDataURL(event.target.files[0]);
                        }
                    </script>

                </div>
            </div>

            <!-- Alamat Card -->
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Alamat</h6>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubahAlamatModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <p><?= esc($alamat['alamat']) ?></p>
                        <a href="<?= esc($alamat['link']) ?>" target="_blank">Lihat di Peta</a>
                    </div>
                </div>
                <!-- Modal Ubah Alamat -->
                <div class="modal fade" id="ubahAlamatModal" tabindex="-1" aria-labelledby="ubahAlamatModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ubahAlamatModalLabel">Ubah Alamat</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/alamat/update') ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="5" required><?= esc($alamat['alamat']) ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="link">Link Peta</label>
                                        <input type="url" class="form-control" id="link" name="link" value="<?= esc($alamat['link']) ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Ubah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jam Pelayanan Card -->
            <div class="col-lg-5">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Jam Pelayanan</h6>
                        <!-- Tombol Ubah -->
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubahJamPelayananModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <p><strong>Buka:</strong> <?= date('H:i', strtotime($jam_pelayanan['buka'])) ?></p>
                        <p><strong>Tutup:</strong> <?= date('H:i', strtotime($jam_pelayanan['tutup'])) ?></p>
                    </div>
                </div>
                <!-- Modal Ubah Jam Pelayanan -->
                <div class="modal fade" id="ubahJamPelayananModal" tabindex="-1" aria-labelledby="ubahJamPelayananModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ubahJamPelayananModalLabel">Ubah Jam Pelayanan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="<?= base_url('admin/jam-pelayanan/update') ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="buka">Jam Buka</label>
                                        <input type="time" class="form-control" id="buka" name="buka" value="<?= esc($jam_pelayanan['buka']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tutup">Jam Tutup</label>
                                        <input type="time" class="form-control" id="tutup" name="tutup" value="<?= esc($jam_pelayanan['tutup']) ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Ubah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Kontak</h6>
                <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahModal">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">Nama Kontak</th>
                                <th style="white-space: nowrap;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kontak as $item): ?>
                                <tr>
                                    <td><?= esc($item['nama']) ?></td>
                                    <td class="text-center">
                                        <!-- Tombol Ubah -->
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubahModal" data-id="<?= esc($item['id']) ?>" data-nama="<?= esc($item['nama']) ?>" data-link="<?= esc($item['link']) ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <a href="<?= base_url('admin/kontak/delete/' . esc($item['id'])) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kontak ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Kontak -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Kontak</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('admin/kontak/store') ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama Kontak</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="link">Link Kontak</label>
                                <input type="text" class="form-control" id="link" name="link" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Ubah Kontak -->
        <div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahModalLabel">Ubah Kontak</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('admin/kontak/update') ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="edit_nama">Nama Kontak</label>
                                <input type="text" class="form-control" id="edit_nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_link">Link Kontak</label>
                                <input type="text" class="form-control" id="edit_link" name="link" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#ubahModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button yang memicu modal
        var id = button.data('id');
        var nama = button.data('nama');
        var link = button.data('link');

        var modal = $(this);
        modal.find('#id').val(id);
        modal.find('#edit_nama').val(nama);
        modal.find('#edit_link').val(link);
    });
</script>
<?= $this->endSection() ?>