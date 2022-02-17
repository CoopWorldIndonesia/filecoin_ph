<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">Payment History</h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- DataTales Example -->

    <table class="text-center tb-custom" width="100%" cellspacing="0">
        <thead class="text-white">
            <tr>
                <th>Date</th>
                <th>Package Name</th>
                <th>Price</th>
                <th>Start mining FIL</th>
                <th>End mining FIL</th>
                <th>Start airdrop ZENX</th>
                <th>End airdrop ZENX</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payment as $row_payment) {
                if ($row_payment->type == 1) {
                    $package_type = 'FIL Mining';
                } elseif ($row_payment->type == 2) {
                    $package_type = 'MTM Mining';
                }
            ?>
                <tr>
                    <td class="tb-column"><?= date('d/m/Y', $row_payment->update_date); ?></td>
                    <td class="tb-column"><?= $row_payment->name . ' ' . $package_type; ?></td>
                    <td class="tb-column">
                        <?php
                        if ($row_payment->fill != 0) {
                            echo $row_payment->fill . " FIL";
                        } elseif ($row_payment->usdt != 0) {
                            echo $row_payment->usdt . " USDT";
                        } elseif ($row_payment->mtm != 0) {
                            echo $row_payment->mtm . " MTM";
                        } elseif ($row_payment->zenx != 0) {
                            echo $row_payment->zenx . " ZENX";
                        }
                        ?>
                    </td>
                    <td class="tb-column"><?= $fil_startpayment; ?></td>
                    <td class="tb-column"><?= $fil_endpayment; ?></td>
                    <td class="tb-column"><?= $mtm_startpayment; ?></td>
                    <td class="tb-column"><?= $mtm_endpayment; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->