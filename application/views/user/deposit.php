<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800 text-center">Deposit</h1> -->
    <?= $this->session->flashdata('message'); ?>
    <ul class="nav nav-tabs tab-deposit justify-content-center" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link <?= $currentTab == 'fil' ? 'active' : ''; ?>" id="filecoin-tab" data-toggle="tab" href="#filecoin" role="tab" aria-controls="filecoin" aria-selected="true">
                FIL
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $currentTab == 'zenx' ? 'active' : ''; ?>" id="zenx-tab" data-toggle="tab" href="#zenx" role="tab" aria-controls="zenx" aria-selected="false">
                ZENX
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade  <?= $currentTab == 'fil' ? 'show active' : ''; ?>" id="filecoin" role="tabpanel" aria-labelledby="filecoin-tab">
            <div class="row">
                <div class="col-md-12">
                    <form class="payment" method="post" action="<?= base_url('user/deposit/1'); ?>">
                        <div class="payment text-center text-white">
                            <div id="qr_code">
                                <p>Address wallet payment</p>
                                <p><img src="<?= base_url('assets/img/wallet_fil_qr.png'); ?>" alt="" width="200"></p>
                                <p class="code-text">
                                    <b><?= $wallet_address['filecoin']; ?></b>
                                </p>
                                <p class="note">Note: Copy TXID</p>
                                <p class="note">* Please re-check the TXID so it's not wrong</p>
                                <p class="note">* Please check the payment amount to match</p>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="txid" name="txid" value="<?= set_value('txid'); ?>" placeholder="Please enter TXID">
                                        <?= form_error('txid', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="coinqty" name="coinqty" value="<?= set_value('coinqty'); ?>" placeholder="Please enter coin quantity">
                                        <?= form_error('coinqty', '<small class="text-danger">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="p-5">
                                        <input type="hidden" name="typecoin" value="1">
                                        <input type="hidden" name="iddeposit" value="<?= $currentTab == 'fil' ? $id_deposit : ''; ?>">
                                        <input type="hidden" name="id_notif" value="<?= $currentTab == 'fil' ? $id_notif : ''; ?>">
                                        <button type="submit" class="btn btn-ok btn-block wd-100-pr">
                                            DEPOSIT REQUEST
                                        </button>
                                    </div>
                                    <div class="p-5">
                                        <a href="<?= base_url('user/cancelPayment'); ?>" class="btn btn-cancel btn-block wd-100-pr" data-toggle="modal" data-target="#cancelModal">
                                            CANCEL
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade <?= $currentTab == 'zenx' ? 'show active' : ''; ?>" id="zenx" role="tabpanel" aria-labelledby="zenx-tab">
            <div class="row">
                <div class="col-md-12">
                    <form class="payment" method="post" action="<?= base_url('user/deposit/3'); ?>">
                        <div class="payment text-center text-white">
                            <div id="qr_code">
                                <p>Address wallet payment</p>
                                <p><img src="<?= base_url('assets/img/wallet_zenx_qr.png'); ?>" alt="" width="200"></p>
                                <p class="code-text">
                                    <b><?= $wallet_address['zenx']; ?></b>
                                </p>
                                <p class="note">Note: Copy TXID</p>
                                <p class="note">* Please re-check the TXID so it's not wrong</p>
                                <p class="note">* Please check the payment amount to match</p>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="txid" name="txid" value="<?= set_value('txid'); ?>" placeholder="Please enter TXID">
                                        <?= form_error('txid', '<small class="text-danger pl-3 float-left">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 m-auto">
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" id="coinqty" name="coinqty" value="<?= set_value('coinqty'); ?>" placeholder="Please enter coin quantity">
                                        <?= form_error('coinqty', '<small class="text-danger pl-3 float-left">', '</small>'); ?>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <div class="p-5">
                                        <input type="hidden" name="typecoin" value="3">
                                        <input type="hidden" name="iddeposit" value="<?= $currentTab == 'zenx' ? $id_deposit : ''; ?>">
                                        <input type="hidden" name="id_notif" value="<?= $currentTab == 'zenx' ? $id_notif : ''; ?>">
                                        <button type="submit" class="btn btn-ok btn-block wd-100-pr">
                                            DEPOSIT REQUEST
                                        </button>
                                    </div>
                                    <div class="p-5">
                                        <a href="<?= base_url('user/cancelPayment'); ?>" class="btn btn-cancel btn-block wd-100-pr" data-toggle="modal" data-target="#cancelModal">
                                            CANCEL
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Logout Modal-->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "OK" below if you are ready to cancel this deposit?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('user/'); ?>">OK</a>
            </div>
        </div>
    </div>
</div>