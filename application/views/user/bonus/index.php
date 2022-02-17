<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">BONUS</h1>
    <?= $this->session->flashdata('message'); ?>

    <!-- content -->
    <div class="row mt-3">
        <div class="col-md-4 mx-auto">
            <a href="<?= base_url('user/sponsor'); ?>" class="btn btn-bonus btn-block">Recommended</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mx-auto">
            <a href="<?= base_url('user/sponsorMatching'); ?>" class="btn btn-bonus btn-block">Recommended Matching</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mx-auto">
            <a href="<?= base_url('user/miningMatching'); ?>" class="btn btn-bonus btn-block">Recommended Mining</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mx-auto">
            <a href="<?= base_url('user/miningGenerasi'); ?>" class="btn btn-bonus btn-block">Mining Matching</a>

        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mx-auto">
            <a href="<?= base_url('user/pairingmatching'); ?>" class="btn btn-bonus btn-block">Pairing</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mx-auto">
            <a href="<?= base_url('user/binaryMatching'); ?>" class="btn btn-bonus btn-block">Pairing Matching</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mx-auto">
            <a href="<?= base_url('user/bonusGlobal'); ?>" class="btn btn-bonus btn-block">Global</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 mx-auto">
            <a href="<?= base_url('user/bonusBasecamp'); ?>" class="btn btn-bonus btn-block">Basecamp</a>
        </div>
    </div>
    <!-- /.content -->

</div>
<!-- /.container-fluid -->

</div>

<!-- End of Main Content -->