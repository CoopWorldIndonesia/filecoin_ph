<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">WITHDRAWAL</h1>
    <!--./ Page Heading -->

    <div>
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="term-condition">
                <h4 class="text-white text-center mb-3">General Balance</h4>
                <form method="post" action="<?php base_url('user/withdrawal_zenx') ?>">
                    <input type="hidden" value="zenx" id="coinType" name="cointype">
                    <div class="form-group border-withdrawal text-white" style="width: 100%; text-align:left !important;">
                        <span><img src="<?= base_url('assets/img/zenith_logo.png') ?>" width="25px">&nbsp; <b>ZENX WALLET</b></span> <span class="float-right"><b><?= str_replace('.', ',', number_format($general, 10)); ?> ZENX</b></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="wallet_address" name="wallet_address" value="<?= set_value('wallet_address'); ?>" placeholder="Wallet Address">
                        <?= form_error('wallet_address', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="amount" name="amount" value="<?= set_value('amount'); ?>" placeholder="Amount" onkeypress="return (event.charCode == 46 || event.charCode < 31 || (event.charCode > 47 && event.charCode < 58))">
                        <?= form_error('amount', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="fee" name="fee" value="<?= set_value('fee'); ?>" placeholder="Fee (<?= $fee_withdrawal['fee_zenx']; ?>%)" readonly>
                        <?= form_error('fee', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="total" name="total" value="<?= set_value('total'); ?>" placeholder="Total" readonly>
                        <?= form_error('total', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div class="form-group input-group check">
                        <input type="text" class="form-control" id="email_code" name="email_code" placeholder="Email Code" value="<?= set_value('email_code'); ?>" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn term-condition border text-white" name="check" type="submit">
                                Check
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="otp_code" name="otp_code" value="<?= set_value('otp_code'); ?>" placeholder="Otp Code">
                        <?= form_error('otp_code', '<p><small class="text-danger pt-1">', '</small></p>'); ?>
                    </div>
                    <div>
                        <textarea class="form-control" rows="7" readonly>Terms and Conditions
                        </textarea>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 mb-2">
                            <button type="submit" class="btn btn-ok border-secondary btn-user btn-block">
                                REQUEST
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="<?= base_url('user/walletzenxgeneral'); ?>" class="btn btn-cancel btn-user btn-block">
                                CANCEL
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->