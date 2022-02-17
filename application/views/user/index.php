<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800">MY HOME</h1> -->
    <?= $this->session->flashdata('message'); ?>

    <div class="card mb-4 bg-trans bd-none">
        <div class="card-body">
            <div class="row mb-4">
                <div id="carousel1" class="carousel slide container-banner" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php foreach ($banner1 as $key => $s) : ?>
                            <li data-target="#carousel1" data-slide-to="<?= $key ?>" class=" <?= ($key == 0) ?  'active' : '' ?>">
                                <img data-target="#carousel1" data-slide-to="<?= $key ?>" class="d-block shadow-img <?= ($key == 0) ?  'active' : '' ?>" src="<?= base_url('assets/photo/banner/' . $s->image) ?>" width="100px" style="" />
                            </li>
                        <?php endforeach; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach ($banner1 as $key => $s) : ?>
                            <div class=" carousel-item <?= ($key == 0) ?  'active' : '' ?> slide">
                                <img class="d-block shadow-img img-slide" src="<?= base_url('assets/photo/banner/' . $s->image) ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <a class="carousel-control-prev" href="#carousel1" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel1" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-12 mb-4 px-0 banner-home2 pr-3">
                    <div id="carousel2" class="carousel slide container-banner2" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($banner2 as $key => $s) : ?>
                                <li data-target="#carousel2" data-slide-to="<?= $key ?>" class=" <?= ($key == 0) ?  'active' : '' ?>"></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($banner2 as $key => $s) : ?>
                                <div class=" carousel-item <?= ($key == 0) ?  'active' : '' ?> slide2">
                                    <img class="d-block shadow-img img-slide2" src="<?= base_url('assets/photo/banner/' . $s->image) ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <a class="carousel-control-prev" href="#carousel2" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel2" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>

                <!-- Market -->
                <div class="col-lg-9 col-sm-12">
                    <div class="mb-4 align-items-center announce <?= empty($news_limit) ? 'd-none' : 'd-flex'; ?>">
                        <div>
                            <h4 class="mb-0 px-3 border-right title-news font-weight-bold">NEWS</h4>
                        </div>
                        <marquee class="h4 mb-0" scrollamount="6">
                            <?php
                            $i = 0;
                            $news_count = count($news_limit) - 2;
                            foreach ($news_limit as $key => $row) : ?>
                                <!-- <span><?= date('Y/m/d', $news['datecreate']); ?></span>&nbsp;&nbsp;|&nbsp;&nbsp;<?= $news['title']; ?> -->
                                <a href="<?= base_url('user/news_announcement/' . $i++); ?>" class="text-decoration-none text-white">
                                    <span class="px-4"><span style="font-size: 14px !important;"><?= date('Y/m/d', $row->datecreate); ?></span>&nbsp;&nbsp;<?= $row->title; ?></span>
                                    <?php if ($key <= $news_count) : ?>
                                        <div class="space-news"></div>
                                    <?php endif ?>
                                </a>
                            <?php endforeach ?>
                        </marquee>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-3 text-white my-home-title">Market</h4>
                        </div>
                        <div class="col-xl-6 col-md-6 my-home mb-2">
                            <div class="card shadow p-2 card-market-index" style="height:145px">
                                <div class="d-flex h-100">
                                    <div class="mr-auto p-2 position-relative w-50">
                                        <img src="<?= base_url('assets/img/zenith_logo.png') ?>" alt="img" width="40px"> <span class="text-white font-w-8 font-dollar">&nbsp;ZENX</span>
                                        <div class="font-market-index h5 mb-0 text-white font-w-8 position-absolute" style="font-size:16px; bottom:0; left:7px">
                                            <i class="fas fa-dollar-sign"></i> <?= $market_price['zenx'] * $general_balance_zenx ?>
                                        </div>
                                    </div>
                                    <!-- <div class="w-50 d-none">
                                        <div class="gauge2 mt-2">
                                            <?php
                                            $i = 12;
                                            $max = 15;
                                            $hasil = $i / $max * 100;
                                            ?>
                                            <div class="arc2" style="background-image:
                                                                radial-gradient(#000 0, #000 60%, transparent 60%),
                                                                conic-gradient(#653a96 0, #c46aa8 <?= $hasil / 100 * 180; ?>deg, #ccc <?= $hasil / 100 * 180; ?>deg, #ccc 180deg, transparent 180deg, transparent 360deg);"></div>
                                            <div class="pointer2" style="transform: rotate(<?= $hasil / 100 * 180; ?>deg) translateX(0%) translateY(-100%);"></div>
                                            <div class="mask2"></div>
                                            <div class="label2"><?= round($hasil, 1) ?>%</div>
                                        </div>
                                    </div> -->
                                    <div class="p-2 position-relative w-50">
                                        <div class="h5 mb-0 text-white text-right font-w-8 font-dollar">
                                            <i class="fas fa-dollar-sign"></i> <?= $market_price['zenx'] ?>
                                        </div>
                                        <p class="font-market-index text-right text-white mb-0 position-absolute" style="font-size:16px; bottom:0; right:7px"> <?= str_replace('.', ',', number_format($general_balance_zenx, 10)); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 my-home mb-2">
                            <div class="card shadow p-2 card-market-index" style="height:145px">
                                <div class="d-flex h-100">
                                    <div class="mr-auto p-2 position-relative w-50">
                                        <img src="<?= base_url('assets/img/filcoin_logo.png') ?>" alt="img" width="40px"> <span class="text-white font-w-8 font-dollar">&nbsp;FIL</span>
                                        <div class="font-market-index h5 mb-0 text-white font-w-8 position-absolute" style="font-size:16px; bottom:0; left:7px">
                                            <i class="fas fa-dollar-sign"></i> <?= $market_price['filecoin'] * $general_balance_fil ?>
                                        </div>
                                    </div>
                                    <div class="p-2 position-relative w-50">
                                        <div class="h5 mb-0 text-white text-right font-w-8 font-dollar">
                                            <i class="fas fa-dollar-sign"></i> <?= $market_price['filecoin'] ?>
                                        </div>
                                        <p class="font-market-index text-right text-white mb-0 position-absolute" style="font-size:16px; bottom:0; right:7px"> <?= str_replace('.', ',', number_format($general_balance_fil, 10)); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BONUS -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mt-4 text-white my-home-title">Bonus</h4>
                        </div>
                        <div class="logo-index col-md-6 text-white my-home-card text-center">
                            <img src="<?= base_url('assets/img/zenith_logo.png'); ?>" width="40px" class="my-2">
                            <span style="font-size:30px;" class="align-middle">&nbsp;ZENX</span>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    BALANCE
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($balance_zenx, 10)); ?>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    TODAY
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($today_zenx, 10)); ?>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    TOTAL
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($total_zenx, 10)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="logo-index col-md-6 text-white my-home-card text-center">
                            <img src="<?= base_url('assets/img/filcoin_logo.png'); ?>" width="40px" class="my-2">
                            <span style="font-size:30px;" class="align-middle">&nbsp;FIL</span>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    BALANCE
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($balance_fil, 10)); ?>
                                    <!-- <?= str_replace('.', ',', $balance_fil); ?>  -->
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    TODAY
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($today_fil, 10)); ?>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    TOTAL
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($total_fil, 10)); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MINING -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mt-4 text-white my-home-title">Mining</h4>
                        </div>
                        <div class="logo-index col-md-6 text-white my-home-card text-center">
                            <img src="<?= base_url('assets/img/zenith_logo.png'); ?>" width="40px" class="my-2">
                            <span style="font-size:30px;" class="align-middle">&nbsp;ZENX</span>
                            <!-- <h1 class=" d-inline my-auto">&nbsp;FIL</h1> -->
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    BALANCE
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($mining_zenx_balance, 10)); ?>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    TODAY
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($mining_zenx_today, 10)); ?>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    TOTAL
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($mining_zenx_total, 10)); ?>
                                </div>
                            </div>
                        </div>
                        <div class="logo-index col-md-6 text-white my-home-card text-center">
                            <img src="<?= base_url('assets/img/filcoin_logo.png'); ?>" width="40px" class="my-2">
                            <span style="font-size:30px;" class="align-middle">&nbsp;FIL</span>
                            <!-- <h1 class=" d-inline my-auto">&nbsp;FIL</h1> -->
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    BALANCE
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($mining_fil_balance, 10)); ?>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    TODAY
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($mining_fil_today, 10)); ?>
                                </div>
                            </div>
                            <div class="d-flex mb-2">
                                <div class="mr-auto p-2 small">
                                    TOTAL
                                </div>
                                <div class="p-2 small">
                                    <?= str_replace('.', ',', number_format($mining_fil_total, 10)); ?>
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

<!-- notif user -->
<?php if (!empty($user['note'])) : ?>
    <div id="modalNote" class="modal fade" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification Alert!</h5>
                </div>
                <div class="modal-body mx-auto">
                    <p><?= $user['note']; ?></p>
                    <a href="<?= base_url('auth/logout'); ?>" class="btn btn-info text-center mx-auto">Oke</a>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<div id="modalBanner" class="modal-banner">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h6 class="modal-title">Modal Banner</h6>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div> -->
            <div class="modal-body">
                <div id="carousel3" class="carousel slide container-banner2 mx-auto" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php foreach ($banner2 as $key => $s) : ?>
                            <li data-target="#carousel3" data-slide-to="<?= $key ?>" class=" <?= ($key == 0) ?  'active' : '' ?>"></li>
                        <?php endforeach; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach ($banner2 as $key => $s) : ?>
                            <div class=" carousel-item <?= ($key == 0) ?  'active' : '' ?> slide2">
                                <img class="d-block shadow-img img-slide2 mx-auto" src="<?= base_url('assets/photo/banner/' . $s->image) ?>" />
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <a class="carousel-control-prev" href="#carousel3" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel3" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="modal-footer d-block">
                <button class="btn float-left nothanks" data-dismiss="modal" aria-hidden="true">Don't Show Again</button>
                <button class="btn btn-secondary float-right" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
    </div>
</div>