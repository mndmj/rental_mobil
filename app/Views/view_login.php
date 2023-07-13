<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentCar</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/all.min.js" integrity="sha512-LW9+kKj/cBGHqnI4ok24dUWNR/e8sUD8RLzak1mNw5Ja2JYCmTXJTF5VpgFSw+VoBfpMvPScCo2DnKTIUjrzYw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <!-- Section: Design Block -->
    <section class="" style="background: url(<?= base_url('img/mobil_rental.jpg') ?>) no-repeat center; background-size: 100%;">
        <!-- Jumbotron -->
        <div class="px-4 py-5 px-md-5 text-center text-lg-start vh-100 d-flex">
            <div class="container m-auto">
                <div class="row gx-lg-5 mx-2 align-items-center">
                    <div class="col-lg-5 mx-5">
                        <h1 class="my-5 display-3 fw-bold ls-tight text-blue">
                            The best offer <br>
                            <span class="text-white">for your rent</span>
                        </h1>
                        <p class="text-capitalize h5 text-secondary">
                            Melayani : Travel, Sewa Mobil & antar jemput bandara,pelabuhan, terminal, dan lain-lain
                        </p>
                    </div>

                    <div class="col-lg-5 mb-5 mb-lg-0">
                        <div class="card text-dark">
                            <div class="card-body py-5 px-md-5">
                                <?= form_open('auth/cek_login') ?>
                                <h2 class="fw-bold ls-tight mb-4 text-center">Rental Mobil Yaa Rozaq</h2>
                                <!-- username input -->
                                <div class="form-outline mb-4">
                                    <!-- <label class="form-label" for="username">Username</label> -->
                                    <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" name="username" id="username" placeholder="Username">
                                    <div id="usernameFeedback" class="invalid-feedback">
                                        <small><?= $validation->getError('username') ?></small>
                                    </div>
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-4">
                                    <!-- <label class="form-label" for="password">Password</label> -->
                                    <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" name="password" id="password" placeholder="Password">
                                    <div id="passwordFeedback" class="invalid-feedback">
                                        <small><?= $validation->getError('password') ?></small>
                                    </div>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4">
                                    Login
                                </button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->

    <?= $this->include('partial/notif.php'); ?>
</body>

</html>