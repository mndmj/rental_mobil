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
                            <td><?= (is_null($dtTransaksi['nama_user'])) ? $dtTransaksi['peminjam'] : $dtTransaksi['nama_user'] ?></td>
                            <td><?= date("d/m/Y H:i:s", strtotime($dtTransaksi['tgl_pesan'])) ?></td>
                            <td><?= date("d/m/Y H:i:s", strtotime($dtTransaksi['tgl_pinjam'])) ?></td>
                            <td><?= (is_null($dtTransaksi['telepon_user'])) ? $dtTransaksi['telp_peminjam'] : $dtTransaksi['telepon_user'] ?></td>
                            <td><?= $dtTransaksi['jaminan'] ?></td>
                        </tr>
                        <?php //}  
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4 shadow">
            <div class="col bg-light rounded p-0">
                <div class="card bg-secondary">
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

<div>
    <?php
    if (!is_null($dtKembali)) {
        $date = $dtKembali['tgl_kembali'];
    } else {
        $date = date("Y-m-d H:i:s");
    }
    $sisa = (int)((strtotime($dtTransaksi['tgl_kembali']) - strtotime($date)) / 3600);
    ?>
    Pinjam : <?= $dtTransaksi['tgl_pinjam'] ?><br>
    Kembali : <?= $dtTransaksi['tgl_kembali'] ?><br>
    Dikembalikan : <?= (is_null($dtKembali)) ? 'Belum' : $date ?><br>
    Sisa Durasi : <?= ($sisa >= 0) ? $sisa : 0 ?> Jam<br>
    Keterlambatan : <?= ($sisa < 0) ? '<span class="text-danger">' . $sisa . '</span>' : 0 ?> Jam<br>
    Denda : Rp <?= ($sisa < 0) ? '<span class="text-danger">' . ($sisa * -1 * 20000) . '</span>' : 0 ?><br>
    <?php if ($dtTransaksi['status_pinjam'] == "Dipinjam") : ?>
        <form id="formPengembalian" method="post" action="<?= base_url('transaksi/pengembalian') ?>">
            <textarea name="kondisi_mobil" id="kondisi_mobil" class="form-control" rows="3" placeholder="Kondisi Mobil"></textarea>
            <input type="text" name="denda_kerusakan" id="denda_kerusakan" class="form-control" placeholder="Denda kerusakan" required>
            <textarea name="kerusakan" id="kerusakan" class="form-control" rows="3" placeholder="Kerusakan"></textarea>
            <div class="form-check-inline">
                <input type="checkbox" name="crashCar" id="crashCar" value="1"> <label for="crashCar">Mobil rusak</label>
            </div>
        </form>
        <button class="btn btn-primary" onclick="pengembalian()">Kembalikan Mobil</button>
    <?php endif ?>
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

    <?php if ($dtTransaksi['status_pinjam'] == "Dipinjam") : ?>

        function pengembalian() {
            Swal.fire({
                title: 'Rent Car',
                text: "Apakah anda yakin mobil telah dikembalikan?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjutkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = $("<input type='hidden' name='id_pinjam' value='<?= $dtTransaksi['id_pinjam'] ?>'>")
                    $("#formPengembalian").append(id);
                    $("#formPengembalian").submit();
                }
            })
        }
    <?php endif ?>
</script>

<?= $this->endSection() ?>