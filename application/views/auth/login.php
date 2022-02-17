<div class="container-fluid">

    <!-- Outer Row -->
    <!-- <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12"> -->

    <div class="card o-hidden border-0 shadow-lg bg-transparent">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row vh-100">
                <!-- <div class="col-lg-8 d-none d-lg-block bg-login-image"></div> -->
                <div class="col-md-4 m-auto">
                    <div class="navmenu-cs flex-rowcs pt-5">
                        <div class="pl-5">
                            <!-- <img src="<?= base_url('assets/img/logo.png'); ?>" alt="" width="150"> -->
                        </div>
                        <!-- <div class="pr-5">
                                        <div class="dropdown no-arrow">
                                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <img class="img-profile rounded-circle"
                                                    src="<?= base_url('assets/img/united-kingdom.png'); ?>" width="24">
                                                <span class="mr-2 d-lg-inline small" style="color: #545454;">English</span>
                                                <i class="fas fa-angle-down" style="color: #565252;"></i>
                                            </a> -->
                        <!-- Dropdown - User Information -->
                        <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                                aria-labelledby="userDropdown">
                                                <a class="dropdown-item" href="#">
                                                    <img class="img-profile rounded-circle"
                                                        src="<?= base_url('assets/img/united-arab-emirates.png'); ?>" width="24">
                                                    <span class="mr-2 d-lg-inline small" style="color: #545454;">Arabic</span>
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <img class="img-profile rounded-circle"
                                                        src="<?= base_url('assets/img/china.png'); ?>" width="24">
                                                    <span class="mr-2 d-lg-inline small" style="color: #545454;">Chinese</span>
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <img class="img-profile rounded-circle"
                                                        src="<?= base_url('assets/img/denmark.png'); ?>" width="24">
                                                    <span class="mr-2 d-lg-inline small" style="color: #545454;">Danish</span>
                                                </a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                                    <img class="img-profile rounded-circle"
                                                        src="<?= base_url('assets/img/philippines.png'); ?>" width="24">
                                                    <span class="mr-2 d-lg-inline small" style="color: #545454 !important;">Filipino</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div> -->
                    </div>
                    <div class="p-5">
                        <div class="text-center signin-header">
                            <div class="justify-content-center flex-row">
                                <div class="p-2">
                                    <img src="<?= base_url('assets/img/filcoin_logo.png'); ?>" alt="logo" width="100px" class="mr-4">
                                    <img src="<?= base_url('assets/img/zenith_logo.png'); ?>" alt="logo">
                                </div>
                                <div class="p-2">
                                    <h1 class="h4 text-white mb-1">FILECOIN & ZENX</h1>
                                    <p class="text-white">Hello, Welcome to FIL x ZENX</p>
                                </div>
                            </div>
                        </div>

                        <?= $this->session->flashdata('message'); ?>

                        <form class="user" method="post" action="<?= base_url('auth'); ?>">
                            <div class="input-group input-group-joined mb-3">
                                <span class="input-group-text">
                                    <img src="<?= base_url('assets/img/icon-02.png'); ?>" alt="icon">
                                </span>
                                <input type="text" class="form-control ps-0" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="ENTER ID">
                            </div>
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>

                            <div class="input-group input-group-joined" id="show_hide_password2">
                                <span class="input-group-text">
                                    <img src="<?= base_url('assets/img/icon-01.png'); ?>" alt="icon">
                                </span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="ENTER PASSWORD">
                                <div class="input-group-append">
                                    <button class="btn" type="button">
                                        <i class="fas fa-eye-slash fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                            <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>

                            <div class="input-group mt-3">
                                <input type="text" class="form-control text-center" id="otp_code" name="otp_code" placeholder="OTP CODE" value="<?= set_value('otp_code'); ?>">
                            </div>
                            <?= form_error('otp_code', '<small class="text-danger pl-3">', '</small>'); ?>

                            <div class="d-flex text-white mt-2">
                                <div class="mr-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="accept_terms">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            id save
                                        </label>
                                    </div>
                                </div>
                                <div class="">
                                    <a class="text-white forgot mr-1" href="<?= base_url('auth/forgotOTP'); ?>">Forgot OTP</a> |
                                    <a class="text-white forgot ml-1" href="<?= base_url('auth/forgotPassword'); ?>">Forgot Password</a>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="p-5">
                                    <button type="submit" class="btn btn-ok btn-block wd-px">
                                        LOGIN
                                    </button>
                                </div>
                                <div class="p-5">
                                    <a class="signup btn btn-cancel btn-block wd-px" href="<?= base_url('auth/registration') ?>">SIGN UP</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="chatbutton">
        <a href="<?= base_url('#'); ?>">
            <img src="<?= base_url('assets/img/chat.png'); ?>" alt="Chat-Button" width="40px">
        </a>
    </div>

    <style>
        .chatbutton {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
        }
    </style> -->

    <!-- </div>

        </div> -->

</div>