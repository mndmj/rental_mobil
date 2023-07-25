<?= $this->extend('template/t_admin') ?>
<?= $this->section('content') ?>

<div class="col rounded">
    <div class="card card-dark mb-0">
        <div class="card-header">
            <h3 class="card-title">Daftar <?= $subtitle ?></h3>
            <div class="card-tools">
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit">
                    <i class="fa fa-pen" aria-hidden="true"></i> Edit</button>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        //foreach ($pinjam as $key => $value) { 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $dtTransaksi['nama_user'] ?></td>
                            <td><?= date("d/m/Y H:i:s", strtotime($dtTransaksi['tgl_pesan'])) ?></td>
                            <td><?= date("d/m/Y H:i:s", strtotime($dtTransaksi['tgl_pinjam'])) ?></td>
                            <td><?= $dtTransaksi['telepon'] ?></td>
                            <td><?= $dtTransaksi['jaminan'] ?></td>
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
<?php //foreach ($pinjam as $key => $value) { 
?>
<div class="modal fade" id="edit<?php //$value['id_pinjam'] 
                                ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php //form_open('transaksi/edit_data/' . $value['id_pinjam']) 
            ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input name="nama_user" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pesan</label>
                            <input name="tgl_pesan" class="form-control" type="datetime-local" placeholder="Tanggal Pesan" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pinjam</label>
                            <input name="tgl_pinjam" class="form-control" type="datetime-local" placeholder="Tanggal Pinjam" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Mobil</label>
                            <select class="form-control" name="nama_mobil" id="nama_mobil" required>
                                <option value="">--Pilih Mobil--</option>
                                <?php //foreach ($mobil as $value) : 
                                ?>
                                <option value="<?php // $value['id_mobil'] 
                                                ?>"><?php // $value['nama'] 
                                                    ?></option>
                                <?php //endforeach 
                                ?>
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
                                <?php //foreach ($jaminan as $value) : 
                                ?>
                                <option value="<?php // $value 
                                                ?>"><?php //$value 
                                                    ?></option>
                                <?php //endforeach 
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"></button>
                <button type="submit" class="btn btn-warning btn-sm">Ubah</button>
            </div>
            <?php //form_close() 
            ?>
        </div>
    </div>
</div>
<?php //} 
?>

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
</script>

<?= $this->endSection() ?>