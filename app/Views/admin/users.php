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
        <h6 class="m-0 font-weight-bold text-primary">Data Users</h6>
        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahModal">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Tanggal Lahir</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="align-middle"><?= esc($user['id_user']) ?></td>
                            <td class="align-middle"><?= esc($user['username']) ?></td>
                            <td class="align-middle"><?= esc($user['email']) ?></td>
                            <td class="align-middle"><?= esc($user['nama_user']) ?></td>
                            <td class="align-middle"><?= esc($user['level']) ?></td>
                            <td class="align-middle"><?= esc($user['tgl_lahir']) ?></td>
                            <td class="align-middle"><?= esc($user['tlp']) ?></td>
                            <td class="align-middle">
                                <button class="btn btn-warning btn-sm" title="Edit" data-toggle="modal" data-target="#ubahModal"
                                    data-id="<?= esc($user['id_user']) ?>"
                                    data-username="<?= esc($user['username']) ?>"
                                    data-email="<?= esc($user['email']) ?>"
                                    data-nama="<?= esc($user['nama_user']) ?>"
                                    data-level="<?= esc($user['level']) ?>"
                                    data-tgl_lahir="<?= esc($user['tgl_lahir']) ?>"
                                    data-tlp="<?= esc($user['tlp']) ?>"
                                    data-alamat="<?= esc($user['alamat']) ?>"
                                    data-gambar="<?= esc($user['gambar']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="<?= base_url('admin/users/delete/' . esc($user['id_user'])) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Tanggal Lahir</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/users/store') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_user">Name</label>
                        <input type="text" class="form-control" id="nama_user" name="nama_user" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                    </div>
                    <div class="form-group">
                        <label for="tlp">Telepon</label>
                        <input type="text" class="form-control" id="tlp" name="tlp">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" id="level" name="level" required>
                            <option value="0">Admin</option>
                            <option value="1">User</option>
                            <option value="2">Guest</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Profile Picture</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('gambar').click();">Choose File</button>
                            <input type="file" class="form-control" id="gambar" name="gambar" style="display:none;" accept="image/*" onchange="previewImage(this);">
                        </div>
                        <img id="preview" src="#" alt="Preview Image" style="display:none; width: 100px; height: 100px; margin-top: 10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
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
                <h5 class="modal-title" id="ubahModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/users/update') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id_user">
                    <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Password</label>
                        <input type="password" class="form-control" id="edit_password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_user">Name</label>
                        <input type="text" class="form-control" id="edit_nama_user" name="nama_user" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="edit_tgl_lahir" name="tgl_lahir">
                    </div>
                    <div class="form-group">
                        <label for="edit_tlp">Telepon</label>
                        <input type="text" class="form-control" id="edit_tlp" name="tlp">
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_level">Level</label>
                        <select class="form-control" id="edit_level" name="level" required>
                            <option value="0">Admin</option>
                            <option value="1">User</option>
                            <option value="2">Guest</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_gambar">Profile Picture</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" onclick="document.getElementById('edit_gambar').click();">Choose File</button>
                            <input type="file" class="form-control" id="edit_gambar" name="gambar" style="display:none;" accept="image/*" onchange="previewEditImage(this);">
                        </div>
                        <img id="edit_preview" src="#" alt="Preview Image" class="img-thumbnail" style="display:none; width: 100px; height: 100px; margin-top: 10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to preview image before upload
    function previewImage(input) {
        var preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewEditImage(input) {
        var preview = document.getElementById('edit_preview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Pass data to the edit modal
    $('#ubahModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var username = button.data('username');
        var email = button.data('email');
        var nama = button.data('nama');
        var level = button.data('level');
        var tgl_lahir = button.data('tgl_lahir');
        var tlp = button.data('tlp');
        var alamat = button.data('alamat');
        var gambar = button.data('gambar');

        var modal = $(this);
        modal.find('#id').val(id);
        modal.find('#edit_username').val(username);
        modal.find('#edit_email').val(email);
        modal.find('#edit_nama_user').val(nama);
        modal.find('#edit_level').val(level);
        modal.find('#edit_tgl_lahir').val(tgl_lahir);
        modal.find('#edit_tlp').val(tlp);
        modal.find('#edit_alamat').val(alamat);

        if (gambar) {
            modal.find('#edit_preview').attr('src', '<?= base_url('uploads') ?>/' + gambar).show();
        }
    });
</script>

<?= $this->endSection() ?>