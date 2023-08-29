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
            <table class="table table-sm" id="tbl_mobil">
                <thead>
                    <tr>
                        <th width="10px">#</th>
                        <th>Foto Mobil</th>
                        <th>Nama Mobil</th>
                        <th>Merk</th>
                        <th>No Polisi</th>
                        <th>Keluaran</th>
                        <th>Bahan Bakar</th>
                        <th>CC</th>
                        <th>Warna</th>
                        <th>Harga Sewa</th>
                        <th>Ketersediaan</th>
                        <th width="50px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($mobil as $key => $value) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <img src="<?= base_url("img/foto_mobil/" . $value['foto_mobil']) ?>" width="150px">
                            </td>
                            <td><?= $value['nama'] ?></td>
                            <td><?= $value['merk'] ?></td>
                            <td><?= $value['no_polisi'] ?></td>
                            <td><?= $value['th_keluaran'] ?></td>
                            <td><?= $value['bahan_bakar'] ?></td>
                            <td><?= $value['cc_mobil'] ?></td>
                            <td><?= $value['warna_mobil'] ?></td>
                            <td>Rp<?= $value['harga_sewa'] ?></td>
                            <td><?= $value['status'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit<?= $value['id_mobil'] ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete<?= $value['id_mobil'] ?>">
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
                <h4 class="modal-title">Add Mobil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('mobil/insert_data') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label for="foto_mobil">Foto Mobil</label>
                        <input type="file" name="foto_mobil" id="foto_mobil">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Nama Mobil</label>
                            <input name="nama" class="form-control" placeholder="Nama Mobil" required>
                        </div>
                        <div class="form-group">
                            <label for="">Merk Mobil</label>
                            <input name="merk" class="form-control" placeholder="Merk Mobil" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nomor Polisi</label>
                            <input name="no_polisi" class="form-control" placeholder="No Polisi" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tahun Keluaran</label>
                            <input name="th_keluaran" class="form-control" placeholder="Keluaran" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Bahan Bakar</label>
                            <input name="bahan_bakar" class="form-control" placeholder="Bahan Bakar" required>
                        </div>
                        <div class="form-group">
                            <label for="">CC Mobil</label>
                            <input name="cc_mobil" class="form-control" placeholder="CC Mobil" required>
                        </div>
                        <div class="form-group">
                            <label for="">Warna Mobil</label>
                            <input name="warna_mobil" class="form-control" placeholder="Warna Mobil" required>
                        </div>
                        <div class="form-group">
                            <label for="">Harga Sewa Mobil</label>
                            <input name="harga_sewa" class="form-control" placeholder="Harga Sewa Mobil" type="number" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary btn-sm mx-auto px-5">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php foreach ($mobil as $key => $value) { ?>
    <div class="modal fade" id="edit<?= $value['id_mobil'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Edit Mobil</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open_multipart('mobil/edit_data/' . $value['id_mobil']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Nama Mobil</label>
                                <input name="nama" value="<?= $value['nama'] ?>" class="form-control" placeholder="Nama Mobil" required>
                            </div>
                            <div class="form-group">
                                <label for="">Merk Mobil</label>
                                <input name="merk" value="<?= $value['merk'] ?>" class="form-control" placeholder="Merk Mobil" required>
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Polisi</label>
                                <input name="no_polisi" value="<?= $value['no_polisi'] ?>" class="form-control" placeholder="No Polisi" required>
                            </div>
                            <div class="form-group">
                                <label for="">Tahun Keluaran</label>
                                <input name="th_keluaran" value="<?= $value['th_keluaran'] ?>" class="form-control" min="1980" placeholder="Keluaran" required>
                            </div>
                            <div class="form-group">
                                <label for="">Status Ketersediaan</label>
                                <select name="status" class="form-control">
                                    <option value="Ada" <?= ($value['status'] == "Ada") ? 'selected' : '' ?>>Ada</option>
                                    <option value="Tidak Ada" <?= ($value['status'] == "Tidak Ada") ? 'selected' : '' ?>>Tidak Ada</option>
                                    <option value="Rusak" <?= ($value['status'] == "Rusak") ? 'selected' : '' ?>>Rusak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Bahan Bakar</label>
                                <input name="bahan_bakar" value="<?= $value['bahan_bakar'] ?>" class="form-control" placeholder="Bahan Bakar" required>
                            </div>
                            <div class="form-group">
                                <label for="">CC Mobil</label>
                                <input name="cc_mobil" value="<?= $value['cc_mobil'] ?>" class="form-control" min="500" placeholder="CC Mobil" required>
                            </div>
                            <div class="form-group">
                                <label for="">Warna Mobil</label>
                                <input name="warna_mobil" value="<?= $value['warna_mobil'] ?>" class="form-control" placeholder="Warna Mobil" required>
                            </div>
                            <div class="form-group">
                                <label for="">Harga Sewa Mobil</label>
                                <input name="harga_sewa" value="<?= $value['harga_sewa'] ?>" type="number" class="form-control" min="1000" placeholder="Harga Sewa Mobil" required>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="foto_mobil">Foto Mobil</label>
                                    <input type="file" name="foto_mobil" id="foto_mobil" onchange="imgPreview('#foto_mobil_preview<?= $value['id_mobil'] ?>', event)" class="form-control-file" accept=".jpg,.jpeg,.png">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <img src="<?= base_url('img/foto_mobil/' . $value['foto_mobil']) ?>" alt="Foto mobil" id="foto_mobil_preview<?= $value['id_mobil'] ?>" class="mt-2" width="200px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-warning btn-sm mx-auto px-5">Ubah</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
<?php } ?>

<!-- Modal Hapus Data -->
<?php foreach ($mobil as $key => $value) { ?>
    <div class="modal fade" id="delete<?= $value['id_mobil'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Hapus Mobil</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda ingin menghapus data <b><?= $value['nama'] ?></b>?
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="<?= base_url('mobil/delete_data/' . $value['id_mobil']) ?>" class="btn btn-danger btn-sm mx-auto px-5">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $('#tbl_mobil').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
</script>

<?= $this->endSection() ?>