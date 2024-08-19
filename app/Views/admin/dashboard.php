<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Peminjaman Terkini</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>ID Peminjaman</th>
                        <th>Nama User</th>
                        <th>Nama Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peminjaman as $item): ?>
                        <tr>
                            <td><?= esc($item['id_peminjaman']) ?></td>
                            <td><?= esc($item['nama_user']) ?></td>
                            <td><?= esc($item['nama_buku']) ?></td>
                            <td><?= esc($item['tgl_pinjam']) ?></td>
                            <td><?= esc($item['tgl_kembali']) ?></td>
                            <td><?= esc($item['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID Peminjaman</th>
                        <th>Nama User</th>
                        <th>Nama Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>