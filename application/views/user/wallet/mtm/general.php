<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">MY WALLET</h1>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4 wallet">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 my-auto">
                            <img class="img-balance" src="<?= base_url('assets/img/mtm_logo.png') ?>" alt="img" width="100px">
                        </div>
                        <div class="col-lg-6 d-none">
                            <!-- <div class="chart-pie float-right" style="width: 100px !important; height:100px !important; ">
                                <canvas id="myPieChart"></canvas>
                            </div> -->
                            <div class="gauge float-right">
                                <?php
                                $i = 13;
                                $max = 15;
                                $hasil = $i / $max * 100;
                                ?>
                                <div class="arc" style="background-image:
                                                    radial-gradient(#000 0, #000 60%, transparent 60%),
                                                    conic-gradient(#e7141a 0, #ec4c48 <?= $hasil / 100 * 180; ?>deg, #ccc <?= $hasil / 100 * 180; ?>deg, #ccc 180deg, transparent 180deg, transparent 360deg);"></div>
                                <div class="pointer" style="transform: rotate(<?= $hasil / 100 * 180; ?>deg) translateX(0%) translateY(-100%);"></div>
                                <div class="mask"></div>
                                <div class="label"><?= round($hasil, 1) ?>%</div>
                            </div>
                        </div>
                        <div class="col-lg-6 text-right">
                            <div class="text-balance font-weight-bold text-white text-uppercase mb-1 ">
                                MTM GENERAL BALANCE
                            </div>
                            <h2 class="amount-balance"><?= number_format($general_balance_mtm, 10, ',', '.'); ?></h2>
                            <div class="dollar-balance h5 mb-0 text-tb-head font-w-8">
                                <i class="fas fa-dollar-sign"></i> <?= $market_price['mtm'] * $general_balance_mtm ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12 mb-4">
            <a href="<?= base_url('user/withdrawal_mtm'); ?>" class="btn btn-ok btn-block">
                Withdrawal
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
                            <div class="h5 mb-0 text-gray-800 ">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-white" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- list withdrawal -->
                                            <?php foreach ($withdrawal as $row_withdrawal) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_withdrawal->datecreate); ?></td>
                                                    <?php if ($row_withdrawal->txid == NULL) : ?>
                                                        <td>
                                                            <span class="badge badge-secondary">withdrawal</span> -
                                                            to <?= $row_withdrawal->wallet_address; ?> (waiting . . .)
                                                        </td>
                                                    <?php else : ?>
                                                        <td>
                                                            <span class="badge badge-secondary">withdrawal</span> -
                                                            to <?= $row_withdrawal->wallet_address; ?> (<?= $row_withdrawal->txid; ?>)
                                                        </td>
                                                    <?php endif ?>
                                                    <td>-<?= number_format($row_withdrawal->amount, 10, ',', '.'); ?></td>
                                                </tr>
                                            <?php endforeach ?>

                                            <!-- list transfer from mining -->
                                            <?php foreach ($transfer_list_mining as $list_mining) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $list_mining->datecreate); ?></td>
                                                    <td>Transfer From Mining</td>
                                                    <td><?= number_format($list_mining->amount, 10, ',', '.'); ?></td>
                                                </tr>
                                            <?php endforeach ?>

                                            <!-- list transfer from bonus -->
                                            <?php foreach ($transfer_list_bonus as $list_bonus) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $list_bonus->datecreate); ?></td>
                                                    <td>Transfer From Bonus</td>
                                                    <td><?= number_format($list_bonus->amount, 10, ',', '.'); ?></td>
                                                </tr>
                                            <?php endforeach ?>

                                            <!-- list deposit -->
                                            <?php foreach ($deposit as $row_deposit) : ?>
                                                <tr>
                                                    <td><?= date('Y/m/d H:i', $row_deposit->datecreate); ?></td>
                                                    <td>
                                                        <span class="badge badge-secondary">deposit</span> -
                                                        from <?= $row_deposit->txid; ?>
                                                    </td>
                                                    <td><?= number_format($row_deposit->coin, 10, ',', '.'); ?></td>
                                                </tr>
                                            <?php endforeach ?>

                                            <!-- list purchase -->
                                            <?php foreach ($purchase as $row_purchase) : ?>
                                                <?php if ($row_purchase->mtm != 0) : ?>
                                                    <tr>
                                                        <td><?= date('Y/m/d H:i', $row_purchase->datecreate); ?></td>
                                                        <td>
                                                            <span class="badge badge-secondary">purchase</span> -
                                                            Package purchase <?= $row_purchase->name; ?>
                                                        </td>
                                                        <td>- <?= number_format($row_purchase->mtm, 10, ',', '.'); ?></td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><?= number_format($general_balance_mtm, 10, ',', '.'); ?></th>
                                            </tr>
                                        </tfoot>
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