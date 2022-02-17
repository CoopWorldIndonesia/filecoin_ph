<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">CHANGE EMAIL</h1>

    <!-- content -->
    <div class="row">
        <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
        <div class="col-md-8 m-auto">
            <div class="">
                <div class="text-center mb-3">
                    <h1 class="h4 text-white">Change Email</h1>
                </div>

                <?= $this->session->flashdata('message'); ?>

                <form class="term-condition" method="post" action="<?php base_url('user/changeEmail') ?>">
                    <div class="input-group check">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Current Email" value="<?= $user['email'] ?>" autocomplete="off" readonly>
                        <div class=" input-group-append">
                            <button class="btn term-condition border text-white" name="check1" type="submit">
                                Check
                            </button>
                        </div>
                    </div>
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class=" mb-2">
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" id="check_code1" name="check_code1" placeholder="Current Email Code" value="<?= set_value('check_code1'); ?>">
                    </div>
                    <?= form_error('check_code1', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="mb-2"></div>
                    <div class="input-group check">
                        <input type="text" class="form-control" id="email2" name="email2" placeholder="Enter New Email" value="<?= set_value('email2'); ?>" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn term-condition border text-white" name="check2" type="submit">
                                Check
                            </button>
                        </div>
                    </div>
                    <?= form_error('email2', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="mb-2"></div>
                    <div class="input-group">
                        <input type="text" class="form-control" id="check_code2" name="check_code2" placeholder="New Email Code" value="<?= set_value('check_code2'); ?>">
                    </div>
                    <?= form_error('check_code2', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class=" mb-2"></div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button type="submit" class="btn btn-ok btn-user btn-block">
                                Submit
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('user/setting'); ?>" class="btn btn-cancel btn-user btn-block">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.content -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->