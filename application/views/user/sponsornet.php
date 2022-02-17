<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white my-home-title">Recommended</h1>

    <div class="row mb-5">
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                1
            </span>
        </div>
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                3
            </span>
        </div>
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                9
            </span>
        </div>
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                15
            </span>
        </div>
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                30
            </span>
        </div>
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                60
            </span>
        </div>
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                120
            </span>
        </div>
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                300
            </span>
        </div>
        <div class="mobile-btn">
            <span class="btn btn-network btn-circle btn-md text-white" style="cursor:default;">
                540
            </span>
        </div>
        <div class="col-md-12 col-sm-12 mt-5" id="">
            <div class="tree zoom dragscroll" style="width: auto; height:98%;">
                <?= $sponsor; ?>
            </div>
        </div>
    </div>
    <div class="tree-controls bg-white text-center float-right d-xl-none d-lg-none d-md-none" style="z-index: 10; position:fixed;bottom:4em;right:1em;">
        <p class="mt-2 text-dark">Tree Controls</p>
        <div class="zoom-header">
            <select id="sel" class="dropdown select" onchange="handleChange()">
                <option value=0.25>25%</option>
                <option value=0.5>50%</option>
                <option value=0.75>75%</option>
                <option value=0.85>85%</option>
                <option value=0.9>90%</option>
                <option value=1 selected>100%</option>
                <option value=1.2>120%</option>
                <option value=1.5>150%</option>
                <option value=1.8>180%</option>
                <option value=1>reset</option>
            </select>
            <span>Zoom</span>
            <div>
                <btn class="zoomin mr-4">
                    <i class="fas fa-plus text-info"></i>
                </btn>
                <btn class="zoomout">
                    <i class="fas fa-minus text-info"></i>
                </btn>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->