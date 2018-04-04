<?php $__env->startSection('content'); ?>
    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">
                        <?php echo $__env->make("comman.school-nav", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                    <?php echo $__env->make("comman.navigation", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="myTabContent" class="tab-content scroll-main-wrapper2">
                        <div role="tabpanel" class="tab-pane fade in active" id="aineisto" aria-labelledby="aineisto-tab">
                            <div class="material-tab">
                                <div class="material-filter">
                                    <div class="">
                                       &nbsp;
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vdesk', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>