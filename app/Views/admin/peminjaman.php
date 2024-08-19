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
        <h6 class="m-0 font-weight-bold text-primary">Data Peminjaman</h6>
        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahModal">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>Nama User</th>
                        <th>Nama Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peminjaman as $item): ?>
                        <tr>
                            <td><?= esc($item['nama_user']) ?></td>
                            <td><?= esc($item['nama_buku']) ?></td>
                            <td><?= esc($item['tgl_pinjam']) ?></td>
                            <td><?= esc($item['tgl_kembali']) ?></td>
                            <td><?= esc($item['status']) ?></td>
                            <td class="align-middle">
                                <!-- Tombol Ubah -->
                                <button class="btn btn-warning btn-sm" title="Ubah"
                                    data-toggle="modal"
                                    data-target="#ubahModal"
                                    data-id_peminjaman="<?= esc($item['id_peminjaman']) ?>"
                                    data-id_user="<?= esc($item['id_user']) ?>"
                                    data-id_buku="<?= esc($item['id_buku']) ?>"
                                    data-nama_user="<?= esc($item['nama_user']) ?>"
                                    data-nama_buku="<?= esc($item['nama_buku']) ?>"
                                    data-tgl_pinjam="<?= esc($item['tgl_pinjam']) ?>"
                                    data-tgl_kembali="<?= esc($item['tgl_kembali']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <a href="<?= base_url('admin/peminjaman/delete/' . $item['id_peminjaman']) ?>"
                                    class="btn btn-danger btn-sm"
                                    title="Hapus"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data peminjaman buku <?= esc($item['nama_buku']) ?> oleh <?= esc($item['nama_user']) ?>?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Nama User</th>
                        <th>Nama Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/peminjaman/store') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_user">Nama User</label>
                        <select class="form-control selectpicker" id="nama_user" name="id_user" data-live-search="true" required>
                            <option selected disabled>Pilih User</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= esc($user['id_user']) ?>"><?= esc($user['nama_user']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_buku">Judul Buku</label>
                        <select class="form-control selectpicker" id="nama_buku" name="id_buku" data-live-search="true" required>
                            <option selected disabled>Pilih Judul</option>
                            <?php foreach ($buku as $book): ?>
                                <option value="<?= esc($book['id_buku']) ?>"><?= esc($book['judul']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_pinjam">Tanggal Pinjam</label>
                        <input type="datetime-local" class="form-control" id="tgl_pinjam" name="tgl_pinjam" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_kembali">Tanggal Kembali</label>
                        <input type="datetime-local" class="form-control" id="tgl_kembali" name="tgl_kembali">
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

<!-- Ubah Modal -->
<div class="modal fade" id="ubahModal" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ubahModalLabel">Ubah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/peminjaman/update') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_id_peminjaman" name="id_peminjaman">
                    <!-- Nama User -->
                    <div class="form-group">
                        <label for="edit_nama_user">Nama User</label>
                        <select class="form-control selectpicker" id="edit_nama_user" name="id_user" data-live-search="true" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= esc($user['id_user']) ?>">
                                    <?= esc($user['nama_user']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Judul Buku -->
                    <div class="form-group">
                        <label for="edit_nama_buku">Judul Buku</label>
                        <select class="form-control selectpicker" id="edit_nama_buku" name="id_buku" data-live-search="true" required>
                            <?php foreach ($buku as $book): ?>
                                <option value="<?= esc($book['id_buku']) ?>">
                                    <?= esc($book['judul']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="form-group">
                        <label for="edit_tgl_pinjam">Tanggal Pinjam</label>
                        <input type="datetime-local" class="form-control" id="edit_tgl_pinjam" name="tgl_pinjam" required>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div class="form-group">
                        <label for="edit_tgl_kembali">Tanggal Kembali</label>
                        <input type="datetime-local" class="form-control" id="edit_tgl_kembali" name="tgl_kembali">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('select').selectpicker(); // Initialize Bootstrap Select
    });

    // Mengisi data ke dalam modal Ubah
    $('#ubahModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var idPeminjaman = button.data('id_peminjaman');
        var idUser = button.data('id_user');
        var idBuku = button.data('id_buku');
        var tglPinjam = button.data('tgl_pinjam');
        var tglKembali = button.data('tgl_kembali');

        var modal = $(this);
        modal.find('#edit_id_peminjaman').val(idPeminjaman);
        modal.find('#edit_nama_user').val(idUser).change();
        modal.find('#edit_nama_buku').val(idBuku).change();
        modal.find('#edit_tgl_pinjam').val(tglPinjam);
        modal.find('#edit_tgl_kembali').val(tglKembali);
    });
</script>

<?= $this->endSection() ?>