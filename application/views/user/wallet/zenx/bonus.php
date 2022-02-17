<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">ZENX BONUS BALANCE</h1>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 wallet">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 my-auto">
                            <img class="img-balance" src="<?= base_url('assets/img/zenith_logo.png') ?>" alt="img" width="100px">
                        </div>
                        <div class="col-9 text-right">
                            <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                ZENX BONUS BALANCE
                            </div>
                            <h2 class="amount-balance"><?= number_format($balance, 10); ?></h2>
                            <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                <i class="fas fa-dollar-sign"></i> <?= $market_price['zenx'] * $balance ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12 mb-4">
            <a href="<?= base_url('user/transfer_bonus_zenx'); ?>" class="btn btn-ok border-secondary btn-block">
                Transfer to General
            </a>
        </div>

        <div class="col-xl-12 col-md-12 mb-4 wallet">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-center font-weight-bold text-white mb-5">
                                History
                            </div>
                            <div class="h5 mb-0 ">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-white" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><?= number_format($balance, 10); ?></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php foreach ($bonus_list as $row_list) : ?>
                                                <?php if ($row_list->zenx != 0) : ?>
                                                    <tr>
                                                        <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                        <td>
                                                            <span class="badge badge-secondary">sponsor</span> -
                                                            ZENX income from <?= $row_list->username; ?>
                                                        </td>
                                                        <td><?= number_format($row_list->zenx, 10); ?></td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_sm_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary">sponsor matching</span> -
                                                        ZENX income from <?= $row_list->username; ?>
                                                    </td>
                                                    <td><?= number_format($row_list->zenx, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_pairingmatch_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary">pairing</span> -
                                                        ZENX income from <?= $row_list->set_amount / 4; ?> set
                                                    </td>
                                                    <td><?= number_format($row_list->zenx, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_binary_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary">pairing matching</span> -
                                                        ZENX income from <?= $row_list->username; ?>
                                                    </td>
                                                    <td><?= number_format($row_list->zenx, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_global_list as $row_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_list->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary">global</span> -
                                                        ZENX income from <?= $row_list->username; ?>
                                                    </td>
                                                    <td><?= number_format($row_list->zenx, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($transfer_list as $trf_list) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $trf_list->datecreate); ?></td>
                                                    <td>Transfer To General</td>
                                                    <td>-<?= number_format($trf_list->amount, 10); ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <?php foreach ($bonus_basecamp_list as $row_list) : ?>
                                                <?php if ($row_list->zenx != 0) : ?>
                                                    <tr>
                                                        <td><?= date('Y/m/d H:i', $row_list->update_date); ?></td>
                                                        <td>
                                                            <span class="badge badge-secondary">basecamp</span> -
                                                            ZENX income from <?= $row_list->username; ?>
                                                        </td>
                                                        <td><?= number_format($row_list->zenx, 10); ?></td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->