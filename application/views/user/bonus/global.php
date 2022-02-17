<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">GLOBAL</h1>

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-body"> -->
    <!-- <div class="table-responsive"> -->
    <?php  
        $fm = $cart['fm'] ?? null;
    ?>
    <div class="row mb-3 px-3">
        <div class="logo-index col-lg-3 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                    Today <?= $fm; ?> :
                </div>
                <div class="p-2 small">
                    <?= $today_fm; ?>
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-3 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                    Total <?= $fm; ?> :
                </div>
                <div class="p-2 small">
                    <?= $all_fm; ?>
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-3 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                    Today Omset :
                </div>
                <div class="p-2 small">
                    <?= empty($today_omset) ? '0' : $today_omset; ?> FIL
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-3 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                    Total Omset this Month :
                </div>
                <div class="p-2 small">
                <?= empty($current_omset) ? '0' : $current_omset; ?> FIL
                </div>
            </div>
        </div>
    </div>
    <table class="text-center tb-custom" width="100%" cellspacing="0">
        <thead class="text-white">
            <tr>
                <th colspan="3" class="text-right">Total: </th>
                <th class="tb-column"><?= $total; ?> Zenx</th>
            </tr>
            <tr>
                <th>Date</th>
                <th>Omset</th>
                <th>accumulation</th>
                <th>Zenx</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($bonus as $row_bonus) {
            ?>
                <tr>
                    <td class="tb-column">
                        <?= date('d/m/Y', $row_bonus->datecreate); ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td class="tb-column">
                        <?= $row_bonus->zenx; ?> Zenx
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <!-- </div> -->
    <!-- </div> -->
    <!-- </div> -->
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->