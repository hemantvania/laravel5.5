<div class="<?php if(Auth::user()->userrole == '2'): ?> col-lg-3 <?php else: ?> col-lg-4 <?php endif; ?>  col-md-5 <?php if(Auth::user()->userrole == '3'): ?> col-sm-6 <?php else: ?> col-sm-12 <?php endif; ?> col-xs-12 user-details">
    <ul class="pull-right">
      
            <li class="flag-options">
                <?php if(config('language.option')): ?>
                    <select class="selectpicker" id="language_switcher">
                        <?php $__currentLoopData = config('language.option'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key == 'en'): ?>
                                <option class="icon2" data-url="<?php echo e(generateLangugeUrl($key)); ?>" <?php if( Lang::locale() == $key): ?> selected <?php endif; ?> ><?php echo e($value); ?></option>
                            <?php elseif($key == 'fi'): ?>
                                <option class="icon1" data-url="<?php echo e(generateLangugeUrl($key)); ?>" <?php if( Lang::locale() == $key): ?> selected <?php endif; ?>><?php echo e($value); ?></option>
                            <?php elseif($key == 'sv'): ?>
                                <option class="icon3" data-url="<?php echo e(generateLangugeUrl($key)); ?>" <?php if( Lang::locale() == $key): ?> selected <?php endif; ?>><?php echo e($value); ?></option>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php endif; ?>
            </li>
  
        <li class="user-option">
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#admin-change-password"><?php echo app('translator')->getFromJson('general.changepassword'); ?></a></li>
                            <?php if(Auth::user()->userrole == '2'): ?> 
                                <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(),route('teacher.schoolwsitch'))); ?>"><?php echo app('translator')->getFromJson('switch.label_switchschool'); ?></a></li>
                            <?php endif; ?>
                            <?php if(Auth::user()->userrole == '5'): ?> 
                                <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/profile'))); ?>"><?php echo app('translator')->getFromJson('general.my_profile'); ?></a></li>
                            <?php endif; ?>
                            <?php if(Auth::user()->userrole == '6'): ?> 
                                <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/profile'))); ?>"><?php echo app('translator')->getFromJson('general.my_profile'); ?></a></li>
                            <?php endif; ?>
                            <?php if(Auth::user()->userrole == '4'): ?>
                                <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/profile'))); ?>"><?php echo app('translator')->getFromJson('general.my_profile'); ?></a></li>
                            <?php endif; ?>
    <li>
        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <?php echo app('translator')->getFromJson('general.logout'); ?>
        </a>

        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
            <?php echo e(csrf_field()); ?>

        </form>
    </li>
</ul>
</li>
</ul>
</li>
</ul>
</div>

