
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-white my-home-title">
                        Achievements 
                    </h1>
                    
                    <?php
                        $cartfm = $cart['fm'] ?? null;
                        
                        $num_level = substr($cartfm,2);

                        if($num_level == '')
                        {
                            $level = 0;
                        }
                        else
                        {
                            $level = $num_level;
                        }
                    ?>

                    <div class="row achievement">
                        <div class="col-md-4 my-3">
                            <div class="card shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM
                                                <?php
                                                    if($level >= 0 && !empty($cart['fm']))
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-md-4 my-3">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 1
                                                <?php
                                                    if($level >= 1)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?= $sponsor < 3 ? $sponsor : '3' ?> BOX / 3 BOX
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 15 ? $omset : '15' ?> BOX / 15 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/15)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 2
                                                <?php
                                                    if($level >= 2)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 9 ? $sponsor : '9' ?> BOX / 9 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/9)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 45 ? $omset : '45' ?> BOX / 45 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/45)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 2)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm1+$fm2+$fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10) < 3) {echo ($fm1+$fm2+$fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10);}else{echo '3';}
                                                    // }
                                                ?> FM1 / 3 FM1
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 2 ? '100' : (($fm1+$fm2+$fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 2)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a1+$team_a2+$team_a3+$team_a4+$team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?> / 1
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a1+$team_a2+$team_a3+$team_a4+$team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 3
                                                <?php
                                                    if($level >= 3)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 15 ? $sponsor : '15' ?> BOX / 15 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/15)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 75 ? $omset : '75' ?> BOX / 75 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/75)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 3)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm2+$fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10) < 3) {echo ($fm2+$fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10);}else{echo '3';}
                                                    // }
                                                ?> FM2 / 3 FM2
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 3 ? '100' : (($fm2+$fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 3)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a2+$team_a3+$team_a4+$team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?>
                                                 / 1
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a2+$team_a3+$team_a4+$team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 4
                                                <?php
                                                    if($level >= 4)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 30 ? $sponsor : '30' ?> BOX / 30 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/30)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 150 ? $omset : '150' ?> BOX / 150 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/150)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 4)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10) < 3) { echo ($fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10); }else{ echo '3'; }
                                                    // }
                                                ?> FM3 / 3 FM3
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 4 ? '100' : (($fm3+$fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 4)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a3+$team_a4+$team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?> / 1
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a3+$team_a4+$team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 5
                                                <?php
                                                    if($level >= 5)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 60 ? $sponsor : '60' ?> BOX / 60 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/60)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 300 ? $omset : '300' ?> BOX / 300 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/300)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 5)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10) < 3) { echo ($fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10); }else{ echo '3'; }
                                                    // }
                                                ?>
                                                FM4 / 3 FM4</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 5 ? '100' : (($fm4+$fm5+$fm6+$fm7+$fm8+$fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 5)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a4+$team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?> / 1
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a4+$team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) >= 1 ? '100' :(0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 6
                                                <?php
                                                    if($level >= 6)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 120 ? $sponsor : '120' ?> BOX / 120 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/120)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 600 ? $omset : '600' ?> BOX / 600 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/600)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 6)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm5+$fm6+$fm7+$fm8+$fm9+$fm10) < 3) { echo ($fm5+$fm6+$fm7+$fm8+$fm9+$fm10); }else{ echo '3'; }
                                                    // }
                                                ?> FM5 / 3 FM5</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 6 ? '100' : (($fm5+$fm6+$fm7+$fm8+$fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 6)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?> / 1</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a5+$team_a6+$team_a7+$team_a8+$team_a9+$team_a10) >= 1 ? '100' :(0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 7
                                                <?php
                                                    if($level >= 7)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 300 ? $sponsor : '300' ?> BOX / 300 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/300)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 1500 ? $omset : '1500' ?> BOX / 1500 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/1500)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 7)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm6+$fm7+$fm8+$fm9+$fm10) < 3) { echo ($fm6+$fm7+$fm8+$fm9+$fm10); }else{ echo '3'; }
                                                    // }
                                                ?> FM6 / 3 FM6</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 7 ? '100' : (($fm6+$fm7+$fm8+$fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 7)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a6+$team_a7+$team_a8+$team_a9+$team_a10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?> / 1</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a6+$team_a7+$team_a8+$team_a9+$team_a10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 8
                                                <?php
                                                    if($level >= 8)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 540 ? $sponsor : '540' ?> BOX / 540 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/540)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 2700 ? $omset : '2700' ?> BOX / 2700 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/2700)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 8)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm7+$fm8+$fm9+$fm10) < 3) { echo ($fm7+$fm8+$fm9+$fm10); }else{ echo '3'; }
                                                    // }
                                                ?> FM7 / 3 FM7
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 8 ? '100' : (($fm7+$fm8+$fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 8)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a7+$team_a8+$team_a9+$team_a10) < 1) {echo $team_a7;}else{echo '1';}
                                                    // }
                                                ?>
                                                 / 1
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a7+$team_a8+$team_a9+$team_a10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                            <?php
                                                // if($level >= 8)
                                                // {
                                                //     echo '1';
                                                // }
                                                // else
                                                // {
                                                    if(($team_c7+$team_c8+$team_c9+$team_c10) < 1) {echo '0';}else{echo '1';}
                                                // }
                                            ?>
                                            / 1</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_c7+$team_c8+$team_c9+$team_c10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team C</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3 m-auto">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase res-mt-2">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 9
                                                <?php
                                                    if($level >= 9)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 720 ? $sponsor : '720' ?> BOX / 720 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/720)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 3600 ? $omset : '3600' ?> BOX / 3600 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/3600)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 9)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm8+$fm9+$fm10) < 3) { echo ($fm8+$fm9+$fm10); }else{ echo '3'; }
                                                    // }
                                                ?> FM8 / 3 FM8
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 9 ? '100' : (($fm8+$fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 9)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a8+$team_a9+$team_a10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?> / 1
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a8+$team_a9+$team_a10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 9)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_c8+$team_c9+$team_c10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?> / 1</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_c8+$team_c9+$team_c10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team C</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 my-3 m-auto">
                            <div class="card border-left-secondary shadow h-100 py-2 purchase res-mt-2">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <h2>
                                                FM 10
                                                <?php
                                                    if($level == 10)
                                                    {
                                                        echo '<i class="fas fa-check-circle fa-xs text-success"></i>';
                                                    }
                                                    else
                                                    {
                                                        echo '<i class="fas fa-times-circle fa-xs text-danger"></i>';
                                                    }
                                                ?>
                                            </h2>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= !empty($cart['name']) ? '1 BOX' : '0 BOX' ?> / 1 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= !empty($cart['name']) ? '100%' : '0%' ?>"
                                                    aria-valuenow="<?= !empty($cart['name']) ? '100' : '0' ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Package Purchase</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $sponsor < 1024 ? $sponsor : '1024' ?> BOX / 1024 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($sponsor/1024)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Sponsor</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small"><?= $omset < 5120 ? $omset : '5120' ?> BOX / 5120 BOX</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($omset/5120)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Turnover</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 10)
                                                    // {
                                                    //     echo '3';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($fm9+$fm10) < 3) { echo ($fm9+$fm10); }else{ echo '3'; }
                                                    // }
                                                ?> FM9 / 3 FM9
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $level >= 10 ? '100' : (($fm9+$fm10)/3)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 9)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_a9+$team_a10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?> / 1
                                            </div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_a9+$team_a10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team A</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="mb-1 small">
                                                <?php
                                                    // if($level >= 9)
                                                    // {
                                                    //     echo '1';
                                                    // }
                                                    // else
                                                    // {
                                                        if(($team_c9+$team_c10) < 1) {echo '0';}else{echo '1';}
                                                    // }
                                                ?>
                                            / 1</div>
                                            <div class="progress progress-sm mb-2">
                                                <div class="progress-bar" role="progressbar" style="width: <?= ($team_c9+$team_c10) >= 1 ? '100' : (0/1)*100;?>%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="mt-1 small font-weight-bold">Team C</div>
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