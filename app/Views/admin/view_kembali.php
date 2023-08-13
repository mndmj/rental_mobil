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
                        <th>Tanggal Pinjam</th>
                        <th>Estimasi Kembali</th>
                        <th>Telepon</th>
                        <th>Kendaraan</th>
                        <th>No Polisi</th>
                        <th width="70px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kembali as $key => $value) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= (is_null($value['nama_user'])) ? $value['peminjam'] : $value['nama_user'] ?></td>
                            <td><?= $value['tgl_pesan'] ?></td>
                            <td><?= $value['tgl_pinjam'] ?></td>
                            <td><?= (is_null($value['telepon_user'])) ? $value['telp_peminjam'] : $value['telepon_user'] ?></td>
                            <td><?= $value['nama_mobil'] ?></td>
                            <td><?= $value['no_polisi'] ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" data-toggle="modal" onclick="window.location.href='<?= base_url('transaksi/detail_kembali/' . $value['id_pinjam']) ?>'">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <!-- <button class="btn btn-sm btn-outline-danger" data-toggle="modal">
                                    <i class="fas fa-trash-alt"></i>
                                </button> -->
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
                <h4 class="modal-title">Data Penyewa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-sm" id="tbl_tr">
                            <thead>
                                <tr>
                                    <th width="50px">#</th>
                                    <th>Nama</th>
                                    <th>Kendaraan</th>
                                    <th>No Polisi</th>
                                    <th width="70px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($dtBelumKembali as $key => $value) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= (is_null($value['nama_user'])) ? $value['peminjam'] : $value['nama_user'] ?></td>
                                        <td><?= $value['nama_mobil'] ?></td>
                                        <td><?= $value['no_polisi'] ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" data-toggle="modal" onclick="window.location.href='<?= base_url('transaksi/detail_kembali/' . $value['id_pinjam']) ?>'">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#tbl_tr').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
</script>

<?= $this->endSection() ?>