<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">RECOMMENDED MINING</h1>

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4"> -->
    <!-- <div class="card-body"> -->
    <!-- <div class="table-responsive"> -->
    <table class="text-center tb-custom" width="100%" cellspacing="0">
        <thead class="text-white">
            <tr>
                <th colspan="3" class="text-right">Total: </th>
                <th class="tb-column"><?= $total; ?> FIL</th>
            </tr>
            <tr>
                <th>Date</th>
                <th>ID</th>
                <th>Team</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($bonus as $row_bonus) {
                // $newDate = $row_bonus->datecreate - 60*60*24;

            ?>
                <tr>
                    <td class="tb-column">
                        <?= date('d/m/Y', $row_bonus->datecreate); ?>
                    </td>
                    <td class="tb-column"><?= $row_bonus->username; ?></td>
                    <td class="tb-column">
                        Team <?= $row_bonus->team; ?>
                    </td>
                    <td class="tb-column">
                        <?= $row_bonus->amount; ?> FIL
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