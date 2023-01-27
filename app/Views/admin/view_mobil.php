<?= $this->extend('template/t_admin') ?>
<?= $this->section('content') ?>

<div class="col-sm p-2">
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Daftar <?= $subtitle ?></h3>
            <!-- tombol aksi -->
            <div class="card-tools">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php
            if (session()->getFlashdata('tambah')) {
                echo '<div class="alert alert-success alert-dismissible peringatan">
                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">&times;</button>
                <h6><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('tambah');
                echo '</h6></div>';
            }

            if (session()->getFlashdata('edit')) {
                echo '<div class="alert alert-warning alert-dismissible peringatan">
                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">&times;</button>
                <h6><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('edit');
                echo '</h6></div>';
            }

            if (session()->getFlashdata('delete')) {
                echo '<div class="alert alert-danger alert-dismissible peringatan">
                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">&times;</button>
                <h6><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('delete');
                echo '</h6></div>';
            }
            ?>

            <table class="table table-sm" id="tbl_mobil">
                <thead>
                    <tr>
                        <th width="70px">#</th>
                        <th>Nama Mobil</th>
                        <th>Jenis Mobil</th>
                        <th>Harga</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    // foreach ($mobil as $key => $value) { 
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn btn-sm btn-flat btn-warning" data-bs-toggle="modal" data-bs-target="#edit">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-flat btn-danger" data-bs-toggle="modal" data-bs-target="#delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php  ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('#tbl_mobil').DataTable();
</script>

<?= $this->endSection() ?>