<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion my-3" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <button id="sidebarToggleTop" class="btn btn-outline-secondary rounded-circle d-md-none mr-3 text-white mx-auto" style="width: min-content;">
        ×
    </button>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user'); ?>">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img src="<?= base_url('assets/img/filcoin_logo.png'); ?>" alt="logo" width="35px;">
            <img src="<?= base_url('assets/img/zenith_logo.png'); ?>" alt="logo" width="35px;">
        </div>
    </a>
    <a class="sidebar-brand pt-3 d-flex align-items-center justify-content-center" href="<?= base_url('user'); ?>">
        <div class="sidebar-brand-text">FILECOIN & ZENX</div>
    </a>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider my-0"> -->

    <li class="nav-item mx-auto text-center">
        <div class="square-sidebar mx-auto">
            <?php if ($user['photo'] != NULL) : ?>
                <img class="img-profile rounded-circle" src="<?= base_url('assets/photo/' . $user['photo']); ?>">
            <?php else : ?>
                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/guest.png'); ?>">
            <?php endif; ?>
        </div>
        <p class="text-white mt-3 mb-0"><?= $user['first_name']; ?></p>
        <p class="text-white mt-0 small">(<?= $user['username']; ?>)</p>
    </li>

    <div class="sidebar-card d-none d-lg-flex">
        <table class="table table-borderless text-white">
            <tr>
                <td>Rank</td>
                <td>: <?= $cart['fm'] ?? null; ?></td>
            </tr>
            <tr>
                <td>Sponsor</td>
                <td>: <?= $cart['sponsor'] ?? null; ?></td>
            </tr>
            <tr>
                <td>Package</td>
                <td>: <?= !empty($cart['name']) ? $cart['name'] . " BOX" : '' ?> </td>
            </tr>
        </table>
    </div>

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= uri_string() == 'user' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-02.png'); ?>" width="25px">&nbsp;
            <span>My Home</span></a>
    </li>

    <!-- Nav Item - Package Purchase -->
    <li class="nav-item <?= $this->uri->segment(2) == 'deposit' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/deposit'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-03.png'); ?>" width="25px">&nbsp;
            <span>Deposit</span></a>
    </li>

    <!-- Nav Item - Package Purchase -->
    <li class="nav-item <?= $this->uri->segment(2) == 'package' || $this->uri->segment(2) == 'packageTour' || $this->uri->segment(2) == 'purchase' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/package'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-04.png'); ?>" width="25px">&nbsp;
            <span>Package Purchase</span></a>
    </li>

    <!-- Nav Item - Bonus -->
    <li class="nav-item <?= uri_string() == 'user/bonusList' || uri_string() == 'user/sponsor' || uri_string() == 'user/sponsorMatching' || uri_string() == 'user/miningMatching' || uri_string() == 'user/miningGenerasi' || uri_string() == 'user/pairingmatching' || uri_string() == 'user/binaryMatching' || uri_string() == 'user/bonusGlobal' || uri_string() == 'user/bonusGlobal' || uri_string() == 'user/bonusBasecamp' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/bonusList'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-05.png'); ?>" width="25px">&nbsp;
            <span>Bonus</span></a>
    </li>

    <!-- Nav Item - My Wallet -->
    <li class="nav-item <?= uri_string() == 'user/mywallet' || uri_string() == 'user/walletfillmining' || uri_string() == 'user/walletfillgeneral' || uri_string() == 'user/walletfillbonus' || uri_string() == 'user/walletmtmgeneral' || uri_string() == 'user/walletmtmairdrop' || uri_string() == 'user/walletmtmbonus' || uri_string() == 'user/walletzenxgeneral' || uri_string() == 'user/walletzenxairdrop' || uri_string() == 'user/walletzenxbonus' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/mywallet'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-06.png'); ?>" width="25px">&nbsp;
            <span>My Wallet</span>
        </a>
    </li>

    <!-- Nav Item - Payment History -->
    <li class="nav-item <?= uri_string() == 'user/history' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/history'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-07.png'); ?>" width="25px">&nbsp;
            <span>Payment History</span></a>
    </li>

    <!-- Nav Item - Filtizen List -->
    <!-- <li class="nav-item">
>>>>>>> af5d498 (design bonus menu and mining matching bonus)
    <a class="nav-link" href="#">
        <i class="fas fa-users"></i>
        <span>Filtizen List</span></a>
</li> -->

    <!-- Nav Item - Network -->
    <li class="nav-item <?= $this->uri->segment(2) == 'network' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/network'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-08.png'); ?>" width="25px">&nbsp;
            <span>Network</span></a>
    </li>

    <!-- Nav Item - Sponsor -->
    <li class="nav-item <?= $this->uri->segment(2) == 'sponsornet' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/sponsornet'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-09.png'); ?>" width="25px">&nbsp;
            <span>Recommended</span></a>
    </li>

    <!-- Nav Item - My Team -->
    <li class="nav-item <?= uri_string() == 'user/myteam' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/myteam'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-10.png'); ?>" width="25px">&nbsp;
            <span>My Team</span></a>
    </li>

    <!-- Nav Item -Achievements Level FM -->
    <li class="nav-item <?= uri_string() == 'user/achievement' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/achievement'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-11.png'); ?>" width="25px">&nbsp;
            <span>Achievements</span></a>
    </li>

    <!-- Nav Item - Information Detail -->
    <li class="nav-item <?= uri_string() == 'user/information_detail' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/information_detail'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-12.png'); ?>" width="25px">&nbsp;
            <span>Information Detail</span></a>
    </li>


    <!-- Nav Item - Marketing Plan -->
    <li class="nav-item <?= uri_string() == 'user/marketing_plan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/marketing_plan'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-13.png'); ?>" width="25px">&nbsp;
            <span>Marketing Plan</span></a>
    </li>

    <!-- Nav Item - Market Trade -->
    <li class="nav-item <?= uri_string() == 'user/market_trade' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('user/market_trade'); ?>">
            <img src="<?= base_url('assets/img/zenx-icon-14.png'); ?>" width="25px">&nbsp;
            <span>Market Trade</span></a>
    </li>
</ul>
<!-- End of Sidebar -->