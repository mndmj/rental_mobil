<?= $this->extend('template/t_admin') ?>
<?= $this->section('content') ?>

<div class="col rounded">
    <div class="card card-dark mb-0">
        <div class="card-header">
            <h3 class="card-title">Daftar <?= $subtitle ?></h3>
            <div class="card-tools">
                <?php if (strtolower($dtTransaksi['sopir']) == "iya" && is_null($dtTransaksi['id_sopir']) && strtolower($dtTransaksi['status_pinjam']) != "kembali") : ?>
                    <button class="btn btn-sm btn-outline-light" data-toggle="modal" data-target="#addSopir">
                        <i class="fa fa-plus" aria-hidden="true"></i> Sopir
                    </button>
                <?php endif ?>
                <?php if ($dtTransaksi['status_pinjam'] == "Booking") : ?>
                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit">
                        <i class="fa fa-pen" aria-hidden="true"></i> Konfirmasi
                    </button>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="card-body pt-0 rounded-bottom shadow-sm border-dark border">
        <div class="row">
            <div class="col">
                <table class="table table-sm" id="tbl_tr">
                    <thead>
                        <tr>
                            <th width="50px">#</th>
                            <th>Nama</th>
                            <th>Tanggal Pesan</th>
                            <th>Tanggal Pinjam</th>
                            <th>Telepon</th>
                            <th>Jaminan</th>
                            <th>Penggunaan Sopir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        //foreach ($pinjam as $key => $value) { 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= (is_null($dtTransaksi['nama_user'])) ? $dtTransaksi['peminjam'] : $dtTransaksi['nama_user'] ?></td>
                            <td><?= date("d/m/Y H:i:s", strtotime($dtTransaksi['tgl_pesan'])) ?></td>
                            <td><?= date("d/m/Y H:i:s", strtotime($dtTransaksi['tgl_pinjam'])) ?></td>
                            <td><?= (is_null($dtTransaksi['telepon_user'])) ? $dtTransaksi['telp_peminjam'] : $dtTransaksi['telepon_user'] ?></td>
                            <td><?= $dtTransaksi['jaminan'] ?></td>
                            <td><?= $dtTransaksi['sopir'] ?></td>
                        </tr>
                        <?php //}  
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4 shadow">
            <div class="col rounded-0 bg-light p-0">
                <div class="card rounded-0 bg-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Detail Kendaraan Disewa</h3>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-sm" id="tbl_tr">
                        <thead>
                            <tr>
                                <th width="50px">#</th>
                                <th>Nama Mobil</th>
                                <th>Merk</th>
                                <th>No Polisi</th>
                                <th>Keluaran</th>
                                <th>Bahan Bakar</th>
                                <th>CC</th>
                                <th>Warna</th>
                                <th>Harga Sewa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            //foreach ($pinjam as $key => $value) { 
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $dtMobil['nama'] ?></td>
                                <td><?= $dtMobil['merk'] ?></td>
                                <td><?= $dtMobil['no_polisi'] ?></td>
                                <td><?= $dtMobil['th_keluaran'] ?></td>
                                <td><?= $dtMobil['bahan_bakar'] ?></td>
                                <td><?= $dtMobil['cc_mobil'] ?></td>
                                <td><?= $dtMobil['warna_mobil'] ?></td>
                                <td><?= $dtMobil['harga_sewa'] ?>/Hari</td>
                            </tr>
                            <?php //}  
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<?php if ($dtTransaksi['status_pinjam'] == "Booking") : ?>
    <div class="modal fade" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('transaksi/checkin/' . $dtTransaksi['id_pinjam']) ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-heading">
                                    <h5 class="text-bold">Perhatian!</h5>
                                </div>
                                Pastikan data dengan benar, karena setelah diinputkan data di bawah ini sudah tidak dapat diubah.
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input name="nama_user" class="form-control" placeholder="Nama" value="<?= $dtTransaksi['peminjam'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Pesan</label>
                                <input name="tgl_pesan" class="form-control" type="datetime-local" placeholder="Tanggal Pesan" value="<?= $dtTransaksi['tgl_pinjam'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Pinjam</label>
                                <input name="tgl_pinjam" class="form-control" type="datetime-local" placeholder="Tanggal Pinjam" value="<?= date("Y-m-d H:i") ?>" disabled required>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Mobil</label>
                                <select class="form-control" name="nama_mobil" id="nama_mobil" disabled required>
                                    <option value=""><?= $dtMobil['nama'] ?> - <?= $dtMobil['harga_sewa'] ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Telepon</label>
                                <input name="telepon" class="form-control" placeholder="Telepon" value="<?= $dtTransaksi['telp_peminjam'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="">No Polisi</label>
                                <input name="no_polisi" class="form-control" placeholder="No Polisi" value="<?= $dtMobil['no_polisi'] ?>" disabled required>
                            </div>
                            <div class="form-group">
                                <label for="">Jaminan</label>
                                <select class="form-control" name="jaminan" id="jaminan">
                                    <option value="">--Pilih Jaminan--</option>
                                    <?php foreach ($jaminan as $value) : ?>
                                        <option value="<?= $value ?>" <?= ($dtTransaksi['jaminan'] == $value) ? 'selected' : '' ?>><?= $value ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-warning btn-sm mx-auto px-5">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
<?php endif ?>

<!-- Modal Tambah Sopir -->
<form action="<?= base_url('transaksi/addsopir') ?>" method="post">
    <div class="modal fade" id="addSopir">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title">Tambah Sopir</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <div class="alert-heading">
                                    <h5 class="text-bold">Perhatian!</h5>
                                </div>
                                Pastikan data dengan benar, karena setelah diinputkan data Sopir sudah tidak dapat diubah.
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table table-sm" id="tbl_sopir">
                                <thead>
                                    <tr>
                                        <th width="10px">#</th>
                                        <th>NIK</th>
                                        <th>Nama Sopir</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dtSopir as $sopir) : ?>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="sopirid" id="sopirid<?= $sopir['id_sopir'] ?>" value="<?= $sopir['id_sopir'] ?>" required>
                                                </div>
                                            </td>
                                            <td>
                                                <label for="sopirid<?= $sopir['id_sopir'] ?>"><?= $sopir['nik'] ?></label>
                                            </td>
                                            <td>
                                                <label for="sopirid<?= $sopir['id_sopir'] ?>"><?= $sopir['nama'] ?></label>
                                            </td>
                                            <td>
                                                <label for="sopirid<?= $sopir['id_sopir'] ?>"><?= $sopir['alamat'] ?></label>
                                            </td>
                                            <td>
                                                <label for="sopirid<?= $sopir['id_sopir'] ?>"><?= $sopir['telepon'] ?></label>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="idPinjam" value="<?= $dtTransaksi['id_pinjam'] ?>">
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary btn-sm mx-auto px-5">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    $('#tbl_tr').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
    $('#tbl_tr2').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
    $('#tbl_sopir').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
</script>

<?= $this->endSection() ?>