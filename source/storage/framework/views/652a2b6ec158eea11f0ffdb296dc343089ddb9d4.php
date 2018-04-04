<?php $__env->startSection('content'); ?>
    <?php echo $__env->make("error.message", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <section class="content-wrapper">
        <div class="container-fluid login-contnet-wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <div class="login-section-title login-page">
                        <img src="<?php echo e(asset('img/student_login_head_logo.png')); ?>" alt="Teacher login" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="login-details-section">
                <div class="col-sm-4">
                    <div class="detail-box">
                        <p> <?php echo app('translator')->getFromJson('login.welcome_desc'); ?> </p>
                    </div>
                </div>
                    <div class="col-sm-4">
                    <div class="login-box">
                        <h2><?php echo app('translator')->getFromJson('login.lable_title'); ?></h2>
                        <div class="login-controls">
                            <form method="POST" action="<?php echo e(generateLangugeUrl(App::getLocale(),url('login'))); ?>">
                                <?php echo e(csrf_field()); ?>

                                <?php if(Session::has('error')): ?>
                                    <div class="alert <?php echo e(Session::get('class')); ?> alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <div class="login-controls--group has-error">
                                        <span class="help-block">
                                            <strong><?php echo app('translator')->getFromJson('login.login_message'); ?></strong>
                                        </span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="login-controls--group <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                <label><?php echo app('translator')->getFromJson('login.field_user'); ?></label>
                                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required />

                                <?php if($errors->has('message')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('message')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="login-controls--group <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                <label><?php echo app('translator')->getFromJson('login.field_password'); ?></label>
                                <input id="password" type="password"  name="password" required />
                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo app('translator')->getFromJson('login.login_pass_mesasge'); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="login-controls--forgotPW">
                                <a href="<?php echo e(route('OtherLogin')); ?>"><?php echo app('translator')->getFromJson('login.lable_teacher'); ?></a> |
                                <a href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->getFromJson('login.lable_forgetpass'); ?></a>
                            </div>
                                <div class="text-right">
                                <button type="submit" class="btn btn-secondary"><?php echo app('translator')->getFromJson('login.lable_login_btn'); ?></button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-4 cust_right_login">
                        <img src="<?php echo e(asset('img/student_login_middle_right.png')); ?>" alt="student_login_middle_right" class="img-responsive" />
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
    jQuery(function(){
        jQuery('#email').focus();
    })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vdesk', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>