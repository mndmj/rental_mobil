<?= $this->extend('template/t_admin') ?>
<?= $this->section('content') ?>

<div class="col-sm p-2">
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Daftar <?= $subtitle ?></h3>
            <!-- tombol aksi -->
            <div class="card-tools">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-sm" id="tbl_sopir">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th>NIK</th>
                        <th>Nama Sopir</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th width="50px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($sopir as $key => $value) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value['nik'] ?></td>
                            <td><?= $value['nama'] ?></td>
                            <td><?= $value['alamat'] ?></td>
                            <td><?= $value['telepon'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit<?= $value['id_sopir'] ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete<?= $value['id_sopir'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php }  ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Add Sopir</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('sopir/insert_data') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">NIK Sopir</label>
                            <input name="nik" class="form-control" placeholder="NIK Sopir" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Sopir</label>
                            <input name="nama" class="form-control" placeholder="Nama Sopir" required>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <input name="alamat" class="form-control" placeholder="Alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="">Telepon</label>
                            <input name="telepon" class="form-control" placeholder="Telepon" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"></button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php foreach ($sopir as $key => $value) { ?>
    <div class="modal fade" id="edit<?= $value['id_sopir'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Edit Sopir</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('sopir/edit_data/' . $value['id_sopir']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">NIK Sopir</label>
                                <input name="nik" value="<?= $value['nik'] ?>" class="form-control" placeholder="NIK Sopir" required>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Sopir</label>
                                <input name="nama" value="<?= $value['nama'] ?>" class="form-control" placeholder="Nama Sopir" required>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <input name="alamat" value="<?= $value['alamat'] ?>" class="form-control" placeholder="Alamat" required>
                            </div>
                            <div class="form-group">
                                <label for="">Telepon</label>
                                <input name="telepon" value="<?= $value['telepon'] ?>" class="form-control" placeholder="Telepon" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"></button>
                    <button type="submit" class="btn btn-warning btn-sm">Ubah</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Hapus Data -->
<?php foreach ($sopir as $key => $value) { ?>
    <div class="modal fade" id="delete<?= $value['id_sopir'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Hapus Sopir</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda ingin menghapus data <b><?= $value['nama'] ?></b>?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal"></button>
                    <a href="<?= base_url('sopir/delete_data/' . $value['id_sopir']) ?>" class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $('#tbl_sopir').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
</script>

<?= $this->endSection() ?>