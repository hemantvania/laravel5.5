<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="format-detection" content="telephone=no"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'vDESK')); ?></title>
    <!-- Bootstrap v3.3.7 CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('plugins/font-awesome/css/font-awesome.min.css')); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo e(asset('plugins/Ionicons/css/ionicons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-select/css/bootstrap-select.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/plugins_select2.min.css')); ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/vdesk.css')); ?>">
<?php echo $__env->yieldContent('page-css'); ?>
<!-- Media Query CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/media-query.css')); ?>">
    <!-- favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('img/favicon32x32.ico')); ?>">
</head>
<!-- Start Body Tag-->
<body>
<div class="wrapper">
    <div class="main-content-wrapper">
        <?php if(Auth::guest()): ?>
            <?php echo $__env->make("layouts.header-login", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make("layouts.header", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
        <div id="push"></div>
    </div>
    <?php echo $__env->make("layouts.footer", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<div id="app"></div>
<!-- REQUIRED JS SCRIPTS -->
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/socket.io/socket.io-1.4.5.js')); ?>"></script>
<script src="<?php echo e(asset('js/global.js')); ?>"></script>
<script src="<?php echo e(asset('js/plugins_select2_select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap-select/js/bootstrap-select.min.js')); ?>"></script>
<script>
    var vdeskLanguage = jQuery('html').attr('lang');
    var sockethost = "<?php echo e(env('REDIS_URI_HOST')); ?>";
    var serverhost = '<?php echo e(strstr($_SERVER['HTTP_HOST'],':', true)); ?>';
    var socket = io.connect("http://202.131.103.44:8122");
    //alert(sockethost);
</script>
<script src="<?php echo e(asset('js/custom.js')); ?>"></script>
<?php echo $__env->yieldContent('scripts'); ?>
<script type="text/javascript">
    var configtime ='<?php echo e(config('session.lifetime')); ?>';
    var timeout = ( configtime * 60) * 1000 ;
    setTimeout(function() {
        //reload on current page
        jQuery("#logout-form").submit();
    }, timeout);
</script>
</body>
<!-- End Body Tag-->
</html>