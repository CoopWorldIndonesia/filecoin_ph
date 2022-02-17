<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">BASECAMP</h1>

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-body"> -->
    <!-- <div class="table-responsive"> -->
    <div class="row mb-3 px-3">
        <div class="logo-index col-lg-4 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                    Basecamp :
                </div>
                <div class="p-2 small">
                    <?= $user['basecamp'];?>
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-4 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                    Today Omset :
                </div>
                <div class="p-2 small">
                    <?= empty($today_omset['fil']) ? '0' : $today_omset['fil']; ?> FIL
                </div>
            </div>
        </div>
        <div class="logo-index col-lg-4 text-white my-home-card text-center">
            <div class="d-flex mb-2">
                <div class="mr-auto p-2 small">
                    Total Omset this Month : 
                </div>
                <div class="p-2 small">
                    <?= empty($total_omset['fil']) ? '0' : $total_omset['fil']; ?> FIL
                </div>
            </div>
        </div>
    </div>
    <table class="text-center tb-custom" width="100%" cellspacing="0">
    <thead class="text-tb-head">
            <tr>
                <th colspan="2" class="text-right">Total: </th>
                <th class="tb-column"><?= $total; ?> Zenx</th>
            </tr>
            <tr>
                <th>Date</th>
                <th>User ID </th>
                <!-- <th>Filecoin</th> -->
                <th>Zenx</th>
                <!-- <th>Type</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($bonus as $row_bonus) {
            ?>
                <tr>
                    <td class="tb-column">
                        <?= date('d/m/Y', $row_bonus->update_date); ?>
                    </td>
                    <td class="tb-column">
                        <?php
                            if($row_bonus->cart_id != 0)
                            {
                                $userId = $userClass->usernameBasecamp($row_bonus->cart_id);
                                echo $userId;
                            }
                            else
                            {
                                echo 'Team '.$row_bonus->team;
                            }
                        ?>
                    </td>
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