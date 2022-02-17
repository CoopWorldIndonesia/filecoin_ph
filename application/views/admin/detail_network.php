<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-white">Network</h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="col-md-12 col-sm-12 mt-5" id="">
        <div class="tree zoom dragscroll" style="width: auto; height:90vh;">
            <?= $network; ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->