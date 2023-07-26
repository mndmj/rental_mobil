<?= $this->extend('template/t_admin') ?>
<?= $this->section('content') ?>

<div class="col rounded">
    <div class="card card-dark mb-0">
        <div class="card-header">
            <h3 class="card-title">Daftar <?= $subtitle ?></h3>
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
        <div class="row mt-4 shadow">
            <div class="col bg-light rounded p-0">
                <div class="card bg-danger">
                    <div class="card-header">
                        <h3 class="card-title">Detail Kondisi Kendaraan</h3>
                    </div>
                </div>
                <div class="card-body pt-0">

                    <?php
                    if (!is_null($dtKembali)) {
                        $date = $dtKembali['tgl_kembali'];
                    } else {
                        $date = date("Y-m-d H:i:s");
                    }
                    $sisa = (int)((strtotime($dtTransaksi['tgl_kembali']) - strtotime($date)) / 3600);
                    ?>

                    <table class="table table-sm mb-3" id="tbl_tr3">
                        <thead>
                            <tr>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Dikembalikan</th>
                                <th>Sisa Durasi</th>
                                <th>Keterlambatan</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $dtTransaksi['tgl_pinjam'] ?></td>
                                <td><?= $dtTransaksi['tgl_kembali'] ?></td>
                                <td><?= (is_null($dtKembali)) ? 'Belum' : $date ?></td>
                                <td><?= ($sisa >= 0) ? $sisa : 0 ?> Jam</td>
                                <td><?= ($sisa < 0) ? '<span class="text-danger">' . $sisa . '</span>' : 0 ?> Jam</td>
                                <td>Rp <?= ($sisa < 0) ? '<span class="text-danger">' . ($sisa * -1 * 20000) . '</span>' : 0 ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if ($dtTransaksi['status_pinjam'] == "Dipinjam") : ?>
                        <form id="formPengembalian" method="post" action="<?= base_url('transaksi/pengembalian') ?>">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="kondisi_mobil">Kondisi mobil</label>
                                        <textarea class="form-control mb-3" name="kondisi_mobil" id="kondisi_mobil" rows="5" placeholder="Kondisi Mobil"></textarea>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="mb-0 form-check-input" type="checkbox" name="crashCar" id="crashCar" value="1">
                                        <label class="m-0" for="crashCar">Mobil Rusak</label><br>
                                    </div>
                                    <small>Centang checklist tersebut ketika mengembalikan mobil dengan keadaan rusak</small>
                                    <div class="form-group mt-4">
                                        <label for="denda_kerusakan">Denda kerusakan</label>
                                        <input class="form-control" type="text" name="denda_kerusakan" id="denda_kerusakan" placeholder="Denda kerusakan" required disabled>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="kerusakan">Kerusakan pada mobil</label>
                                        <textarea class="form-control mb-3" name="kerusakan" id="kerusakan" rows="5" placeholder="Kerusakan" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="w-100 d-flex">
                            <button class="btn btn-danger mx-auto px-5 mt-3" onclick="pengembalian()">Kembalikan Mobil</button>
                        </div>
                    <?php endif ?>
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
    $('#tbl_tr2').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
    $('#tbl_tr3').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });

    $("#crashCar").click(function() {
        if (document.getElementById('crashCar').checked == true) {
            $("#denda_kerusakan").removeAttr('disabled');
            $("#kerusakan").removeAttr('disabled');
        } else {
            $("#denda_kerusakan").attr('disabled', '');
            $("#kerusakan").attr('disabled', '');
        }
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