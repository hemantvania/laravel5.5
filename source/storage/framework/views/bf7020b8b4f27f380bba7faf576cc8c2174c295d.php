<ul class="schoolnav navbar nav nav-pills">
    <li class="<?php echo setActivePrifix( App::getLocale().'/'.generateUrlPrefix().'/dashboard'); ?>"><a href="<?php echo e(generateDashboardLink(Auth::user()->userrole)); ?>"><?php echo app('translator')->getFromJson('general.welcome'); ?> <?php echo e(Auth::user()->userRoles->rolename); ?></a></li>
    <li role="presentation" class="dropdown <?php echo setActivePrifix(App::getLocale().'/'.generateUrlPrefix().'/teacher'); ?>">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <?php echo app('translator')->getFromJson('sidebarmenu.teacher'); ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/teacher'))); ?>"><?php echo app('translator')->getFromJson('sidebarmenu.teacher'); ?></a></li>
            <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/teacher/add'))); ?>"><?php echo app('translator')->getFromJson('sidebarmenu.addnew'); ?></a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown <?php echo setActivePrifix(App::getLocale().'/'.generateUrlPrefix().'/students'); ?>">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <?php echo app('translator')->getFromJson('sidebarmenu.student'); ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/students'))); ?>"><?php echo app('translator')->getFromJson('sidebarmenu.student'); ?></a></li>
            <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/students/add'))); ?>"><?php echo app('translator')->getFromJson('sidebarmenu.addnew'); ?></a></li>
        </ul>
    </li>
    <li role="presentation" class="dropdown <?php echo setActivePrifix(App::getLocale().'/'.generateUrlPrefix().'/classes'); ?>">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <?php echo app('translator')->getFromJson('sidebarmenu.classes'); ?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/classes'))); ?>"><?php echo app('translator')->getFromJson('sidebarmenu.classes'); ?></a></li>
            <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/classes/create'))); ?>"><?php echo app('translator')->getFromJson('sidebarmenu.addnew'); ?></a></li>
           <!-- <li><a href="<?php echo e(generateLangugeUrl(App::getLocale(), url(generateUrlPrefix().'/classes/assign-class'))); ?>">Assign Class</a></li> -->
        </ul>
    </li>
</ul>
