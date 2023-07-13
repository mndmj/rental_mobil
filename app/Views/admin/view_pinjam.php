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
            <table class="table table-sm" id="tbl_tr">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th>Nama</th>
                        <th>Tanggal Pesan</th>
                        <th>Tanggal Pinjam</th>
                        <th>Telepon</th>
                        <th>Kendaraan</th>
                        <th>No Polisi</th>
                        <th width="70px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pinjam as $key => $value) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value['nama_user'] ?></td>
                            <td><?= $value['tgl_pesan'] ?></td>
                            <td><?= $value['tgl_pinjam'] ?></td>
                            <td><?= $value['telepon_user'] ?></td>
                            <td><?= $value['nama_mobil'] ?></td>
                            <td><?= $value['no_polisi'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal" onclick="window.location.href='<?= base_url('transaksi/detail') ?>'">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" data-toggle="modal">
                                    <i class="fas fa-trash-alt"></i>
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
                <h4 class="modal-title">Add Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('transaksi/insert_data') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input name="nama_user" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pesan</label>
                            <input name="tgl_pesan" class="form-control" type="datetime-local" placeholder="Tanggal Pesan" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pinjam</label>
                            <input name="tgl_pinjam" class="form-control" type="datetime-local" placeholder="Tanggal Pinjam" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Mobil</label>
                            <select class="form-control" name="nama_mobil" id="nama_mobil" required>
                                <option value="">--Pilih Mobil--</option>
                                <?php foreach ($mobil as $value) : ?>
                                    <option value="<?= $value['id_mobil'] ?>"><?= $value['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Telepon</label>
                            <input name="telepon" class="form-control" placeholder="Telepon" required>
                        </div>
                        <div class="form-group">
                            <label for="">No Polisi</label>
                            <input name="no_polisi" class="form-control" placeholder="No Polisi" required>
                        </div>
                        <div class="form-group">
                            <label for="">Jaminan</label>
                            <select class="form-control" name="jaminan" id="jaminan" required>
                                <option value="">--Pilih Jaminan--</option>
                                <?php foreach ($jaminan as $value) : ?>
                                    <option value="<?= $value ?>"><?= $value ?></option>
                                <?php endforeach ?>
                            </select>
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

<!-- Modal Hapus Data -->
<?php foreach ($pinjam as $key => $value) { ?>
    <div class="modal fade" id="delete<?= $value['id_pinjam'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Hapus Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda ingin menghapus data <b><?= $value['nama'] ?></b>?
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal"></button>
                    <a href="<?= base_url('transaksi/delete_data/' . $value['id_pinjam']) ?>" class="btn btn-danger btn-sm">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $('#tbl_tr').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
</script>

<?= $this->endSection() ?>