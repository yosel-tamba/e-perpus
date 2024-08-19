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
        <h6 class="m-0 font-weight-bold text-primary">Data News</h6>
        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahModal">
            <i class="fas fa-plus"></i> Tambah News
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news as $item): ?>
                        <tr>
                            <td class="align-middle"><?= esc($item['id']) ?></td>
                            <td class="align-middle"><?= esc($item['judul']) ?></td>
                            <td class="align-middle"><?= esc($item['tanggal']) ?></td>
                            <td class="align-middle"><img src="<?= base_url('img/news/' . esc($item['gambar'])) ?>" width="100"></td>
                            <td class="align-middle">
                                <button class="btn btn-warning btn-sm"
                                    title="Ubah"
                                    data-toggle="modal"
                                    data-target="#ubahModal"
                                    data-id="<?= esc($item['id']) ?>"
                                    data-judul="<?= esc($item['judul']) ?>"
                                    data-isi="<?= esc($item['isi']) ?>"
                                    data-tanggal="<?= esc($item['tanggal']) ?>"
                                    data-gambar="<?= esc($item['gambar']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('news/delete/' . esc($item['id'])) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
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

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah News</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('news/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="isi">Isi</label>
                        <textarea class="form-control" id="isi" name="isi" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <div class="text-center">
                            <div id="imagePreviewContainer" class="mb-2">
                                <img id="imagePreview" src="<?= base_url('img/news/default.png') ?>" alt="Image Preview" style="width: 100%;" class="rounded">
                            </div>
                            <label for="gambar" class="btn btn-primary">Pilih Gambar</label>
                            <input type="file" class="d-none" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)" required>
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

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


<!-- Ubah Modal -->
<div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahModalLabel">Ubah News</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('news/update') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">

                    <div class="form-group">
                        <label for="edit_judul">Judul</label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_isi">Isi</label>
                        <textarea class="form-control" id="edit_isi" name="isi" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal</label>
                        <input type="datetime-local" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <div class="text-center">
                            <div id="editImagePreviewContainer" class="mt-2">
                                <img id="editImagePreview" src="<?= base_url('img/default.png') ?>" alt="Current Image" style="display: block; width: 100%;" class="rounded">
                            </div>
                            <label for="edit_gambar" class="btn btn-primary">Pilih Gambar</label>
                            <input type="file" class="d-none" id="edit_gambar" name="gambar" accept="image/*" onchange="previewEditImage(event)">
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
    function previewEditImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('editImagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    $('#ubahModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var judul = button.data('judul');
        var isi = button.data('isi');
        var tanggal = button.data('tanggal');
        var gambar = button.data('gambar');

        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#edit_judul').val(judul);
        modal.find('#edit_isi').val(isi);
        modal.find('#edit_tanggal').val(tanggal);
        modal.find('#editImagePreview').attr('src', '<?= base_url('img/news/') ?>' + gambar);
    });
</script>

<?= $this->endSection() ?>