<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">
        MY TEAM
    </h1>

    <div class="bg-custom p-5 mb-4">
        <div class="">
            <?php if ($team_a != NULL) : ?>
                <div class="row">
                    <h3 class="m-auto text-white" <?= $team_a == NULL ? 'hidden' : '' ?>>TEAM A</h3>
                </div>
                <div class="row mt-3">
                    <?php
                    foreach ($team_a as $row_team_a) {
                    ?>
                        <div class="col-lg-4 mb-4">
                            <div class="team-custom p-2 text-center text-white">
                                <h3>
                                    <?= $row_team_a->username; ?>
                                </h3>
                                <div class="mt-2">
                                    <?= $row_team_a->email; ?>
                                </div>
                                <div>
                                    <?= $row_team_a->name; ?>
                                </div>
                                <div>
                                    <?= date('d/m/Y', $row_team_a->datecreate); ?>
                                </div>
                                <div class="mb-2">
                                    <?= $row_team_a->fm; ?>
                                </div>
                                <div>
                                    <img class="myteam-img" src="<?= base_url('assets/img/filcoin_logo.png'); ?>" alt="" width="70em">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="row mt-4">
                    <h3 class="m-auto text-white" <?= $team_b == NULL ? 'hidden' : '' ?>>TEAM B</h3>
                </div>
                <div class="row mt-3">
                    <?php
                    foreach ($team_b as $row_team_b) {
                    ?>
                        <div class="col-lg-4 mb-4">
                            <div class="team-custom p-2 text-center text-white">
                                <h3>
                                    <?= $row_team_b->username; ?>
                                </h3>
                                <div class="mt-2">
                                    <?= $row_team_b->email; ?>
                                </div>
                                <div>
                                    <?= $row_team_b->name; ?>
                                </div>
                                <div>
                                    <?= date('d/m/Y', $row_team_b->datecreate); ?>
                                </div>
                                <div class="mb-2">
                                    <?= $row_team_b->fm; ?>
                                </div>
                                <div>
                                    <img class="myteam-img" src="<?= base_url('assets/img/filcoin_logo.png'); ?>" alt="" width="70em">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="row mt-4">
                    <h3 class="m-auto text-white" <?= $team_c == NULL ? 'hidden' : '' ?>>TEAM C</h3>
                </div>
                <div class="row mt-3">
                    <?php
                    foreach ($team_c as $row_team_c) {
                    ?>
                        <div class="col-lg-4 mb-4">
                            <div class="team-custom p-3 text-center text-white">
                                <h3>
                                    <?= $row_team_c->username; ?>
                                </h3>
                                <div class="mt-2">
                                    <?= $row_team_c->email; ?>
                                </div>
                                <div>
                                    <?= $row_team_c->name; ?>
                                </div>
                                <div>
                                    <?= date('d/m/Y', $row_team_c->datecreate); ?>
                                </div>
                                <div class="mb-4">
                                    <?= $row_team_c->fm; ?>
                                </div>
                                <div>
                                    <img class="myteam-img" src="<?= base_url('assets/img/filcoin_logo.png'); ?>" alt="" width="70em">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php else : ?>
                <h5 class="text-white text-center">Your team was not found.</h5>
            <?php endif ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->