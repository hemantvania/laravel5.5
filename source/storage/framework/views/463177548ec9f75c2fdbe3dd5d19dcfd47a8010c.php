<header>
    <div class="top-head vdesk_cyan teacher clearfix">
        <div class="row">
            <ul class="message-option">
                <?php if(Auth::user()->userrole == 3): ?>
                    <li>
                        <div class="dropdown cq-dropdown dropdown-custom" data-name='statuses'>
                            <button class="open_msg_box btn btn-default btn-sm " type="button" id="dropdown1" data-id="<?php if(!empty($eDeskList)): ?><?php echo e($eDeskList[0]->user_id); ?> <?php endif; ?>" data-userrole="2" data-name="">
                                <?php echo app('translator')->getFromJson('teacher.label_message_to_teacher'); ?>
                            </button>
                        </div>
                    </li>
                    <li id="share_screen">
                        <div  class="dropdown cq-dropdown dropdown-custom" data-name='statuses'>
                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <?php echo app('translator')->getFromJson('general.takeEConsole'); ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdown1">
                                <li><ul id="share_screen_students">
                                        <?php $__currentLoopData = $eDeskList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($student->id != Auth::user()->id && $student->userrole != 2 ): ?>
                                            <li>
                                                <label class="radio-btn">
                                                    <input type="checkbox" value="<?php echo e($student->id); ?>" name="share-screen-student-list" data-title="<?php echo e($student->name); ?>" /><?php echo e($student->name); ?>

                                                </label>
                                            </li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                                <li class='text-center cust-border'>
                                    <button type="button"  id="sharescreen" class="btn btn-kirjoita"><?php echo app('translator')->getFromJson('teacher.btn_sharescreen'); ?></button>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->userrole == 2): ?>
                    <li id="chat_students">
                        <div  class="dropdown cq-dropdown dropdown-custom" data-name='statuses'>
                            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <?php echo app('translator')->getFromJson('teacher.label_send_message'); ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdown1">
                                <li><ul id="online_students">
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <label class="radio-btn">
                                                    <input type="checkbox" value="<?php echo e($student->id); ?>" name="chat-student-list" data-title="<?php echo e($student->fullname); ?>" /><?php echo e($student->fullname); ?>

                                                </label>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                                <li class='text-center cust-border'>
                                    <button type="button"  id="startchat" class="btn btn-kirjoita"><?php echo app('translator')->getFromJson('teacher.label_write_message'); ?></button>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->userrole == 2 ): ?>
                    <?php if($screenAuth == 1): ?>
                        <li id="share_screen">
                            <div  class="dropdown cq-dropdown dropdown-custom" data-name='statuses'>
                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <?php echo app('translator')->getFromJson('general.takeEConsole'); ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown1">
                                    <li><ul id="share_screen_students">
                                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <label class="radio-btn">
                                                        <input type="checkbox" value="<?php echo e($student->id); ?>" name="share-screen-student-list" data-title="<?php echo e($student->fullname); ?>" /><?php echo e($student->fullname); ?>

                                                    </label>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </li>
                                    <li class='text-center cust-border'>
                                        <button type="button"  id="sharescreen" class="btn btn-kirjoita"><?php echo app('translator')->getFromJson('teacher.btn_sharescreen'); ?></button>
                                    </li>
                                </ul>
                            </div>
                        </li>
                     <?php endif; ?>
                <?php endif; ?>
            </ul>
            <?php if(Auth::user()->userrole == 2): ?>
            <ul class="video-option pull-right">
                <li>
                    <button id="play" class="btn-play"><i class="fa fa-play-circle" aria-hidden="true"></i>
                        <?php echo app('translator')->getFromJson('teacher.label_hour'); ?></button>
                </li>
                <!--
                --->
                <li>
                    <button class="btn-pause"><i class="fa fa-pause" aria-hidden="true"></i>
                        <?php echo app('translator')->getFromJson('teacher.label_break'); ?></button>
                </li>
                <!--
                --->
                <li>
                    <button class="btn-stop"><i class="fa fa-stop" aria-hidden="true"></i>
                        <?php echo app('translator')->getFromJson('teacher.label_end'); ?></button>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="logo-section clearfix">
        <?php if(Auth::user()->userrole != ''): ?>
            <?php if(Auth::user()->userrole == '2'): ?>
            <div class="school-logo">
                <a href="<?php echo e(generateDashboardLink(Auth::user()->userrole)); ?>" title="School Logo">
                    <?php if($logourl != '' ): ?>
                        <img src="<?php echo e($logourl); ?>" alt="School Logo" class="img-responsive" style="height: 55px;"/>
                    <?php else: ?>
                        <img src="<?php echo e(asset('img/school_logo_placeholder.png')); ?>" alt="School Logo" class="img-responsive" style="height: 55px;"/>
                    <?php endif; ?>
                </a>
            </div>
            <?php endif; ?>
        <div class="vdesk-logo"> <a href="<?php echo e(generateDashboardLink(Auth::user()->userrole)); ?>" title="vDESK Logo"><img src="<?php echo e(asset('img/pulpo_logo.png')); ?>" alt="vDESK Logo" class="img-responsive" /></a> </div>
        <?php else: ?>
            <div class="school-logo"> <a href="<?php echo e(url('home')); ?>" title="School Logo"><img src="<?php echo e(asset('img/school-logo.jpg')); ?>" alt="School Logo" class="img-responsive" /></a> </div>
            <div class="vdesk-logo"> <a href="<?php echo e(url('home')); ?>" title="vDESK Logo"><img src="<?php echo e(asset('img/pulpo_logo.png')); ?>" alt="vDESK Logo" class="img-responsive" /></a> </div>
        <?php endif; ?>
    </div>
</header>
<script>

    function getRandomColor() {
        var colorsarr = [
            '#F48274','#FDC913','#7AC29E','#31B0E1','#29B0E4'
        ];
        var randomNumber = Math.floor(Math.random()*colorsarr.length);

        /*var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }*/
        return colorsarr[randomNumber];
    }
</script>