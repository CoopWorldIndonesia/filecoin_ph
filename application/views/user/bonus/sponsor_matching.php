<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">RECOMMENDED MATCHING</h1>

    <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Receive</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Excess</a>
        </li>
    </ul>
    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div> -->
    <!-- <div class="card-body">
                            <div class="table-responsive"> -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table class="text-center tb-custom" width="100%" cellspacing="0">
                <thead class="text-white">
                    <tr>
                        <th colspan="2" class="text-right">Total: </th>
                        <th class="tb-column"><?= $total_fil; ?> FIL</th>
                        <th class="tb-column"><?= $total_zenx; ?> ZENX</th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>User ID</th>
                        <th>Filecoin</th>
                        <th>Zenx</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($bonus as $row_bonus) { ?>
                        <tr>
                            <td class="tb-column"><?= date('d/m/Y', $row_bonus->datecreate); ?></td>
                            <td class="tb-column"><?= $row_bonus->username; ?></td>
                            <td class="tb-column"><?= $row_bonus->filecoin; ?> FIL</td>
                            <td class="tb-column"><?= $row_bonus->zenx; ?> Zenx</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <table class="text-center tb-custom" width="100%" cellspacing="0">
                <thead class="text-tb-head">
                    <tr>
                        <th colspan="2" class="text-right">Total: </th>
                        <th class="tb-column"><?= $total_excess; ?> ZENX</th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>User ID</th>
                        <th>ZENX</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($excess_bonus as $row_excess) {
                    ?>
                        <tr>
                            <td class="tb-column"><?= date('d/m/Y', $row_excess->datecreate); ?></td>
                            <td class="tb-column"><?= $row_excess->username; ?></td>
                            <td class="tb-column"><?= $row_excess->zenx; ?> ZENX</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- </div>
                        </div> -->
    <!-- </div> -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->