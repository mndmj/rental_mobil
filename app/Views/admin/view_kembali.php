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
                        <th></th>
                        <th width="50px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kembali as $key => $value) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit<?php ?>">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete<?php ?>">
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

<script>
    $('#tbl_tr').DataTable({
        bFilter: false,
        bPaginate: false,
        bInfo: false
    });
</script>

<?= $this->endSection() ?>