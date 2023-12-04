<?= $this->extend('template/t_admin') ?>
<?= $this->section('content') ?>

<div class="col-sm p-2">
    <div class="card bg-danger">
        <div class="card-body">
            <div class="h3 mb-3 font-weight-bold"><i class="fa-solid fa-triangle-exclamation fa-xs"></i>&ensp;Perhatian</div>
            <p>Data pada tabel dengan tanda <b>diblock warna kuning</b> pertanda status pemesanannya Booking.</p>
        </div>
    </div>
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
                        <th>Status Pinjam</th>
                        <th>Telepon</th>
                        <th>Kendaraan</th>
                        <th>No Polisi</th>
                        <th width="90px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pinjam as $key => $value) { ?>
                        <?php $dateDiff = (int)((strtotime($value['tgl_pinjam']) - strtotime(date("Y-m-d H:i"))) / 3600); ?>
                        <tr class="<?= (strtolower($value['status_pinjam']) == "booking" && $dateDiff < 0) ? 'bg-warning' : '' ?>">
                            <td><?= $no++ ?></td>
                            <td><?= (is_null($value['nama_user'])) ? $value['peminjam'] : $value['nama_user'] ?></td>
                            <td><?= $value['tgl_pesan'] ?></td>
                            <td><?= $value['tgl_pinjam'] ?></td>
                            <td><?= $value['status_pinjam'] ?></td>
                            <td><?= (is_null($value['telepon_user'])) ? $value['telp_peminjam'] : $value['telepon_user'] ?></td>
                            <td><?= $value['nama_mobil'] ?></td>
                            <td><?= $value['no_polisi'] ?></td>
                            <td>
                                <?php if (is_null($value['jaminan'])) : ?>
                                    <button class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#modalChangeJaminan" onclick="setChangeJaminanData('<?= $value['id_pinjam'] ?>','<?= (is_null($value['nama_user'])) ? $value['peminjam'] : $value['nama_user'] ?>', '<?= $value['telp_peminjam'] ?>')">
                                        <i class="fas fa-id-card"></i>
                                    </button>
                                <?php endif ?>
                                <button class="btn btn-sm btn-info" onclick="window.location.href='<?= base_url('transaksi/detail/' . $value['id_pinjam']) ?>'">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if ($value['status_pinjam'] == "Booking") : ?>
                                    <button class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#delete<?= $value['id_pinjam'] ?>">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                <?php endif ?>
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
            <?= form_open('transaksi/savepinjam') ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input name="nama_user" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pesan</label>
                            <input name="tgl_pesan" class="form-control" type="datetime-local" value="<?= date("Y-m-d H:i") ?>" placeholder="Tanggal Pesan" disabled required>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input type="radio" name="ck_tipe_pinjam" id="ck_tipe_pinjam1" class="form-check-input" value="sekarang" checked onclick="tipePinjam('sekarang')">
                                <label class="form-check-label" for="ck_tipe_pinjam1" onclick="tipePinjam('sekarang')">Sekarang</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="ck_tipe_pinjam" id="ck_tipe_pinjam2" class="form-check-input" value="booking" onclick="tipePinjam('booking')">
                                <label class="form-check-label" for="ck_tipe_pinjam2" onclick="tipePinjam('booking')">Booking</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pinjam</label>
                            <input name="tgl_pinjam" id="tgl_pinjam" class="form-control" type="datetime-local" placeholder="Tanggal Pinjam" oninput="checkStatusMobil()" required>
                        </div>
                        <div class="form-group">
                            <label for="">Durasi Pinjam</label>
                            <input name="durasi_pinjam" id="durasi_pinjam" class="form-control" type="number" placeholder="Banyaknya Hari" onchange="checkStatusMobil()" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Mobil <small class="text-warning" id="listMobilNotify"></small></label>
                            <select class="form-control" name="nama_mobil" id="nama_mobil" onchange="setNoPol(this.value)" required>
                                <option value="">--Pilih Mobil--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Telepon</label>
                            <input name="telepon" class="form-control" placeholder="Telepon" required>
                        </div>
                        <div class="form-group">
                            <label for="">No Polisi</label>
                            <input name="no_polisi" id="no_polisi" class="form-control" placeholder="No Polisi" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Dengan Sopir</label>
                            <select class="form-control" name="sopir" id="sopir" onclick="setBiayaSopir(this.value)" required>
                                <option value="Tidak">Tidak</option>
                                <option value="Iya">Iya</option>
                            </select>
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
                <h6 class="my-auto">
                    Total Bayar : <span id="lblTotalBayar"></span>
                </h6>
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
<!-- Modal -->
<form action="<?= base_url('transaksi/changejaminan') ?>" method="post" id="formChangeJaminan">
    <div class="modal fade" id="modalChangeJaminan" tabindex="-1" aria-labelledby="modalChangeJaminanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalChangeJaminanLabel">Pilih Jaminan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Penyewa</label>
                        <input class="form-control" id="changeJaminan_nama" disabled readonly required>
                    </div>
                    <div class="form-group">
                        <label>Telp Penyewa</label>
                        <input class="form-control" id="changeJaminan_telepon" disabled readonly required>
                    </div>
                    <div class="form-group">
                        <label for="changeJaminan">Jaminan</label>
                        <select class="form-control" name="changeJaminan" id="changeJaminan" required>
                            <option value="">--Pilih Jaminan--</option>
                            <?php foreach ($jaminan as $value) : ?>
                                <option value="<?= $value ?>"><?= $value ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <input type="hidden" name="changeJaminan_id" id="changeJaminan_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    let hargaSewa = [];
    let biayaSopir = 0;

    function setBiayaSopir(val) {
        if (val == "Iya") {
            biayaSopir = Number(<?= $biayaSopir ?>);
        } else {
            biayaSopir = 0;
        }
        setTotalSewa($("#nama_mobil").val());
    }

    $('#tbl_tr').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });

    function tipePinjam(val) {
        if (val == null || val == "") {
            alert("Mohon pilih tipe servis");
        } else {
            if (val == "sekarang") {
                $("#tgl_pinjam").attr("disabled", "");
                let today = new Date();
                let date = today.getFullYear() + '-' + ((Number((today.getMonth() + 1)) < 10) ? "0" + (today.getMonth() + 1) : (today.getMonth() + 1)) + '-' + ((Number(today.getDate()) < 10) ? "0" + today.getDate() : today.getDate());
                let time = ((Number(today.getHours()) < 10) ? "0" + today.getHours() : today.getHours()) + ":" + ((Number(today.getMinutes() < 10) ? "0" + today.getMinutes() : today.getMinutes()));
                let dateTime = date + ' ' + time;
                $("#tgl_pinjam").val(dateTime);
            } else {
                $("#tgl_pinjam").val("");
                $("#tgl_pinjam").removeAttr("disabled");
            }
            checkStatusMobil();
        }
        console.log($("#tgl_pinjam").val());
    }

    tipePinjam('sekarang');

    function checkStatusMobil() {
        $("#listMobilNotify").addClass('text-warning');
        $("#listMobilNotify").removeClass('text-success');
        $("#nama_mobil").empty();
        hargaSewa = [];
        if ($("#tgl_pinjam").val() != "") {
            if (Number($("#durasi_pinjam").val()) > 0) {
                $("#listMobilNotify").html("(Load data mobil)");
                if ($("input[name='ck_tipe_pinjam']:checked").val() != "sekarang") {
                    $("#tgl_pinjam").attr("disabled", "");
                }
                $("#durasi_pinjam").attr("disabled", "");
                $("#nama_mobil").attr("disabled", "");
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('mobil/getfreemobil') ?>',
                    contentType: 'application/json',
                    data: {
                        tanggal: $("#tgl_pinjam").val(),
                        durasi: String($("#durasi_pinjam").val())
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $("#listMobilNotify").html(response.msg);
                            $("#listMobilNotify").removeClass('text-warning');
                            $("#listMobilNotify").addClass('text-success');
                            response.data.forEach(element => {
                                let opt = $("<option></option>");
                                opt.html(element.nama + " - " + element.no_polisi + " (Rp " + rupiah(element.harga_sewa) + ")");
                                opt.attr('value', element.no_polisi);
                                hargaSewa.push({
                                    no_pol: element.no_polisi,
                                    harga_sewa: element.harga_sewa
                                });
                                $("#nama_mobil").append(opt);
                            });
                            setTotalSewa($("#nama_mobil").val());
                            setNoPol($("#nama_mobil").val());
                        } else {
                            $("#listMobilNotify").html(response.msg);
                        }
                        if ($("input[name='ck_tipe_pinjam']:checked").val() != "sekarang") {
                            $("#tgl_pinjam").removeAttr("disabled");
                        }
                        $("#durasi_pinjam").removeAttr("disabled");
                        $("#nama_mobil").removeAttr("disabled");
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(xhr.statusText);
                        if ($("input[name='ck_tipe_pinjam']:checked").val() != "sekarang") {
                            $("#tgl_pinjam").removeAttr("disabled");
                        }
                        $("#durasi_pinjam").removeAttr("disabled");
                        $("#nama_mobil").removeAttr("disabled");
                    }
                });
            } else {
                $("#listMobilNotify").html("(Durasi minimal 1 hari)");
                setTotalSewa("");
            }
        } else {
            $("#listMobilNotify").html("(Silahkan pilih tanggal pinjam dan durasi pinjam dahulu)");
            setTotalSewa("");
        }
    }
    checkStatusMobil();

    function setNoPol(val) {
        $("#no_polisi").val(val);
        setTotalSewa(val);
    }

    function setTotalSewa(val) {
        if (val != "") {
            let tmpHarga = 0;
            hargaSewa.forEach(element => {
                if (element.no_pol == val) {
                    tmpHarga = element.harga_sewa;
                    return false;
                }
            });
            $("#lblTotalBayar").html("Rp " + rupiah((Number($("#durasi_pinjam").val()) * Number(tmpHarga)) + Number(biayaSopir)));
        } else {
            $("#lblTotalBayar").html("Rp 0");
        }
    }

    function setChangeJaminanData(id, nama, telepon) {
        $("#changeJaminan_id").attr("value", id);
        $("#changeJaminan_nama").attr("value", nama);
        $("#changeJaminan_telepon").attr("value", telepon);
    }
</script>

<?= $this->endSection() ?>