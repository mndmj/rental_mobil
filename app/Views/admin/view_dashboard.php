<?= $this->extend('template/t_admin') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-3 col-12">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>Mobil</h3>
                <p>Jumlah data : <?= $mobil ?></p>
            </div>
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
            <a href="<?= base_url('mobil') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-12">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>Sopir</h3>
                <p>Jumlah data : <?= $sopir ?></p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card"></i>
            </div>
            <a href="<?= base_url('sopir') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-12">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>Peminjaman</h3>
                <p>Jumlah data : 0</p>
            </div>
            <div class="icon">
                <i class="fas fa-upload"></i>
            </div>
            <a href="<?= base_url('admin') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-12">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>Pengembalian</h3>
                <p>Jumlah data : 0</p>
            </div>
            <div class="icon">
                <i class="fas fa-download"></i>
            </div>
            <a href="<?= base_url('admin') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>