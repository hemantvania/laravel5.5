<?php $__env->startSection("page-css"); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="content-wrapper">
  <div class="container-fluid inner-contnet-wrapper">
    <div class="tab-wrapper">
      <div class="row">
        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details"> <?php echo $__env->make("comman.school-nav", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </div>
        <?php echo $__env->make("comman.navigation", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> </div>
    </div>

  </div>
</section>
<section class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
          <div class="scroll-main-wrapper2">
              <?php echo $__env->make('error.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
             <?php echo $__env->make('layouts.user_profile', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          </div>
      </div>
  </div>
</section>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.vdesk', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>