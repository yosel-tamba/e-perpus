<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
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
        <h6 class="m-0 font-weight-bold text-primary">Data Galeri</h6>
        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahModal">
            <i class="fas fa-plus"></i> Tambah Galeri
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gallery as $item): ?>
                        <tr>
                            <td class="align-middle"><?= esc($item['id']) ?></td>
                            <td class="align-middle"><?= esc($item['keterangan']) ?></td>
                            <td class="align-middle"><?= esc($item['tanggal']) ?></td>
                            <td class="align-middle"><img src="<?= base_url('img/galeri/' . esc($item['gambar'])) ?>" width="100" class="rounded"></td>
                            <td class="align-middle">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubahModal" data-id="<?= esc($item['id']) ?>" data-keterangan="<?= esc($item['keterangan']) ?>" data-tanggal="<?= esc($item['tanggal']) ?>" data-gambar="<?= esc($item['gambar']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('admin/gallery/delete/' . esc($item['id'])) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus item galeri ini?')">
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

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Galeri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/gallery/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <div class="text-center">
                            <div class="form-group">
                                <img id="previewTambah" src="<?= base_url('img/galeri/default.png') ?>" alt="Preview Gambar" style="max-width: 100%;" class="rounded" />
                            </div>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('gambar').click();">Pilih Gambar</button>
                            <input type="file" class="d-none" id="gambar" name="gambar" accept="image/*" required onchange="previewTambahImage(event)">
                            <small class="form-text text-danger">File gambar harus diupload.</small>
                        </div>
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

<!-- Modal Ubah -->
<div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahModalLabel">Ubah Galeri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/gallery/update') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="edit_keterangan">Keterangan</label>
                        <input type="text" class="form-control" id="edit_keterangan" name="keterangan" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <div class="text-center">
                            <div class="form-group">
                                <img id="previewUbah" src="#" alt="Preview Gambar" style="max-width: 100%; display: none;" class="rounded" />
                            </div>
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('edit_gambar').click();">Pilih Gambar</button>
                            <input type="file" class="d-none" id="edit_gambar" name="gambar" onchange="previewUbahImage(event)" accept="image/*">
                            <small class="form-text text-danger">Biarkan jika tidak ingin mengubah gambar.</small>
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
    $('#ubahModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var keterangan = button.data('keterangan');
        var gambar = button.data('gambar');

        var modal = $(this);
        modal.find('#id').val(id);
        modal.find('#edit_keterangan').val(keterangan);

        if (gambar) {
            $('#previewUbah').attr('src', '<?= base_url('img/galeri/') ?>' + gambar).show();
        }
    });

    function previewUbahImage(event) {
        var preview = document.getElementById('previewUbah');
        var reader = new FileReader();
        reader.onload = function() {
            preview.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function previewTambahImage(event) {
        var preview = document.getElementById('previewTambah');
        var reader = new FileReader();
        reader.onload = function() {
            preview.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?= $this->endSection() ?>