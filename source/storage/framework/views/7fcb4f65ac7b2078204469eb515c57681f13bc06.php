<header>
    <div class="top-head vdesk_lightgray clearfix">
        <div class="row">
            <ul class="language">
                <?php if(config('language.option')): ?>
                    <?php $__currentLoopData = config('language.option'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($value)): ?>
                            <li><a href="<?php echo e(generateLangugeUrl($key)); ?>" title="<?php echo e($value); ?>" class="language-switcher <?php if($loop->index == 0): ?> active <?php endif; ?>" data-id="<?php echo e($key); ?>">
                                    <?php if($key == 'en'): ?>
                                        <img src="<?php echo e(asset('img/english-flag.jpg')); ?>" alt="english-flag" />
                                    <?php elseif($key == 'fi'): ?>
                                        <img src="<?php echo e(asset('img/finnish-flag.jpg')); ?>" alt="finnish-flag" />
                                    <?php elseif($key == 'sv'): ?>
                                        <img src="<?php echo e(asset('img/swedish-flag.jpg')); ?>" alt="swedish-flag" />
                                    <?php endif; ?>
                                </a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="logo-section clearfix">
        <div class="school-logo"> <a href="<?php echo e(url('/home')); ?>" title="School Logo"><img src="<?php echo e(asset('img/school-logo.jpg')); ?>" alt="School Logo" class="img-responsive" /></a> </div>
        <div class="vdesk-logo"> <a href="<?php echo e(url('/home')); ?>" title="PULPO Logo"><img src="<?php echo e(asset('img/pulpo_logo.png')); ?>" alt="PULPO Logo" class="img-responsive" /></a> </div>
    </div>
</header>
