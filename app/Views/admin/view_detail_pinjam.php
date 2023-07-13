<?= $this->extend('template/t_admin') ?>
<?= $this->section('content') ?>

<div class="col">
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Daftar <?= $subtitle ?></h3>
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
                //foreach ($pinjam as $key => $value) { 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-info" data-toggle="modal" onclick="window.location.href='<?= base_url('transaksi/detail') ?>'">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" data-toggle="modal">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                <?php //}  
                ?>
            </tbody>
        </table>
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