           <form id="addedit_user" role="form" <?php if(isset($userDetail)): ?> action="<?php echo e(generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/profile/'.$userDetail->id.'/update'))); ?>" <?php else: ?>  action="<?php echo e(generateLangugeUrl(App::getLocale(),url(generateUrlPrefix().'/users/add'))); ?>" <?php endif; ?> method="post" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>


                <input id="hid_user_id" name="user_id" type="hidden" value="<?php if(isset($userDetail)): ?><?php echo e($userDetail->id); ?><?php endif; ?>">
                <input id="hid_country" name="country" type="hidden"value="<?php if(!empty($userDetail->userMeta->country)): ?><?php echo e($userDetail->userMeta->country); ?><?php endif; ?>">
               <?php if(isset($userDetail->userrole) && ($userDetail->userrole == 3 || $userDetail->userrole == 5 || $userDetail->userrole == 6  ) ): ?>
                <input id="hid_user_role" name="userrole" type="hidden" value="<?php if(isset($userDetail)): ?><?php echo e($userDetail->userrole); ?><?php endif; ?>">
                <input id="hid_schoolId" name="schoolId[]" type="hidden" value="<?php if(!empty($user_schools[0]) ): ?><?php echo e($user_schools[0]); ?><?php endif; ?>">
                <?php endif; ?>
               <?php if($userDetail->userrole == 5): ?>
                   <input id="default_school" name="default_school" type="hidden" value="1">
               <?php else: ?>
                   <input id="default_school" name="default_school" type="hidden" value="<?php if(!empty($userDetail->userMeta->default_school)): ?><?php echo e($userDetail->userMeta->default_school); ?><?php elseif(!empty($user_schools[0])): ?><?php echo e($user_schools[0]); ?><?php endif; ?>">
               <?php endif; ?>
               <?php if($userDetail->userrole == 2): ?>
                   <input id="enable_share_screen" name="enable_share_screen" type="hidden" value="<?php if(!empty($userDetail->userMeta->enable_share_screen)): ?><?php echo e($userDetail->userMeta->enable_share_screen); ?><?php endif; ?>">
               <?php endif; ?>

                <div class="col-lg-3 col-xs-12">
                    <h4 class="personal-info-header"><?php echo app('translator')->getFromJson('adminuser.profileimage'); ?></h4>
                    <div class="picture-upload-cust">
                        <?php if(!empty($userDetail->userMeta->profileimage)): ?>
                            <img src="<?php echo e(url($userDetail->userMeta->profileimage)); ?>">
                            <!--button type="button" class="btn picture-remove"><i class="material-icons">close</i></button-->
                            <label class="checkbox-inline"><input name="remove_logo" value="1" type="checkbox"><?php echo app('translator')->getFromJson('general.remove_profile_pic'); ?></label>
                        <?php else: ?>
                            <img src="<?php echo e(asset('img/user2-160x160.jpg')); ?>">
                        <?php endif; ?>
                    </div>
                    <?php if(Auth::user()->userrole != 3): ?>
                    <div class="browse-picture-cust">
                        <label class="btn btn-vdesk btn-file">
                            <span id="logoname"><?php echo app('translator')->getFromJson('adminuser.uploadphoto'); ?></span>

                            <input id="user_profile" type="file" name="profileimage" style="display:none;">

                        </label>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-9 col-xs-12">
                    <div class="row">
                        <div class="col-lg-4 col-xs-12">
                            <div class="row">
                                <h4 class="personal-info-header"><?php echo app('translator')->getFromJson('general.label_rersonal_details'); ?></h4>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.first_name'); ?><em>*</em></label>
                                    <input type="text"   <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" name="name" value="<?php if(!empty($userDetail->first_name)): ?><?php echo e($userDetail->first_name); ?><?php else: ?><?php echo e(old('name')); ?><?php endif; ?>" placeholder="<?php echo app('translator')->getFromJson('adminuser.first_name'); ?>">
                                    <?php if($errors->has('name')): ?>
                                        <span class="help-block">
                                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                                </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.last_name'); ?><em>*</em></label>
                                    <input type="text" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" name="last_name" value="<?php if(!empty($userDetail->last_name)): ?><?php echo e($userDetail->last_name); ?><?php else: ?><?php echo e(old('last_name')); ?><?php endif; ?>" placeholder="<?php echo app('translator')->getFromJson('adminuser.last_name'); ?>">
                                    <?php if($errors->has('last_name')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('last_name')); ?></strong>
                                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.email'); ?><em>*</em></label>
                                    <input type="email" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" value="<?php if(!empty($userDetail->email)): ?><?php echo e($userDetail->email); ?><?php else: ?><?php echo e(old('email')); ?><?php endif; ?>" name="email" placeholder="<?php echo app('translator')->getFromJson('adminuser.email'); ?>">
                                    <?php if($errors->has('email')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.password'); ?><em>*</em></label>
                                    <input type="password" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" value="" name="password" autocomplete="off" placeholder="<?php echo app('translator')->getFromJson('adminuser.password'); ?>">
                                    <?php if($errors->has('password')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('ssn') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.ssn'); ?></label>
                                    <input type="text" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" value="<?php if(!empty($userDetail->userMeta->ssn)): ?><?php echo e($userDetail->userMeta->ssn); ?><?php else: ?><?php echo e(old('ssn')); ?><?php endif; ?>" name="ssn" placeholder="<?php echo app('translator')->getFromJson('adminuser.ssn'); ?>">
                                    <?php if($errors->has('ssn')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('ssn')); ?></strong>
                                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.gender'); ?></label>

                                    <select class="selectpicker" name="gender" id="gender" <?php if(Auth::user()->userrole == 3): ?> disabled <?php endif; ?>>
                                        <option value="1" <?php if(empty($userDetail->userMeta->gender) || ( $userDetail->userMeta->gender == 1)): ?> selected="selected" <?php endif; ?> ><?php echo app('translator')->getFromJson('adminuser.male'); ?></option>
                                        <option value="2" <?php if(!empty($userDetail->userMeta->gender) && ( $userDetail->userMeta->gender == 2)): ?> selected="selected" <?php endif; ?> ><?php echo app('translator')->getFromJson('adminuser.female'); ?></option>
                                        <option value="3" <?php if(!empty($userDetail->userMeta->gender) && ( $userDetail->userMeta->gender == 3)): ?> selected="selected" <?php endif; ?>><?php echo app('translator')->getFromJson('adminuser.other'); ?></option>
                                    </select>
                                    <?php if($errors->has('gender')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('gender')); ?></strong>
                                                    </span>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">

                            <div class="row">
                                <h4 class="personal-info-header"><?php echo app('translator')->getFromJson('general.label_address_details'); ?></h4>

                                <div class="form-group col-xs-12 <?php echo e($errors->has('addressline1') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.addressline1'); ?><em>*</em></label>
                                    <input type="text" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" value="<?php if(!empty($userDetail->userMeta->addressline1)): ?><?php echo e(trim($userDetail->userMeta->addressline1)); ?><?php else: ?><?php echo e(old('addressline1')); ?><?php endif; ?>"  name="addressline1" placeholder="<?php echo app('translator')->getFromJson('adminuser.addressline1'); ?>">
                                    <?php if($errors->has('addressline1')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('addressline1')); ?></strong>
                                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('addressline2') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.addressline2'); ?></label>
                                    <input type="text" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" value="<?php if(!empty($userDetail->userMeta->addressline2)): ?><?php echo e($userDetail->userMeta->addressline2); ?><?php else: ?><?php echo e(old('addressline2')); ?><?php endif; ?>" name="addressline2" placeholder="<?php echo app('translator')->getFromJson('adminuser.addressline2'); ?>">
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('phone') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.phone'); ?><em>*</em></label>
                                    <input type="text" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" value="<?php if(!empty($userDetail->userMeta->phone)): ?><?php echo e($userDetail->userMeta->phone); ?><?php else: ?><?php echo e(old('phone')); ?><?php endif; ?>" name="phone" placeholder="<?php echo app('translator')->getFromJson('adminuser.phone'); ?>">
                                    <?php if($errors->has('phone')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('phone')); ?></strong>
                                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('city') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('adminuser.city'); ?><em>*</em></label>
                                    <input type="text" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> class="form-control" value="<?php if(!empty($userDetail->userMeta->city)): ?><?php echo e($userDetail->userMeta->city); ?><?php else: ?><?php echo e(old('city')); ?><?php endif; ?>" name="city" placeholder="<?php echo app('translator')->getFromJson('adminuser.city'); ?>">
                                    <?php if($errors->has('city')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('city')); ?></strong>
                                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-xs-12 <?php echo e($errors->has('zip') ? ' has-error' : ''); ?>">
                                    <label><?php echo app('translator')->getFromJson('general.postal_code'); ?><em>*</em></label>
                                    <input id="postal_code" <?php if(Auth::user()->userrole == 3): ?> readonly <?php endif; ?> type="text" class="form-control" value="<?php if(!empty($userDetail->userMeta->zip)): ?><?php echo e($userDetail->userMeta->zip); ?><?php else: ?><?php echo e(old('zip')); ?><?php endif; ?>" name="zip" placeholder="<?php echo app('translator')->getFromJson('general.postal_code'); ?>">
                                    <?php if($errors->has('zip')): ?>
                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('zip')); ?></strong>
                                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <?php if(isset($userDetail) && ( $userDetail->userrole == 2 || $userDetail->userrole == 4 || $userDetail->userrole == 6) ): ?>
                                <div class="row">
                                    <h4 class="personal-info-header"><?php echo app('translator')->getFromJson('general.label_other_details'); ?></h4>

                                    <div class="form-group col-xs-12">
                                        <label><?php echo app('translator')->getFromJson('general.label_myschool'); ?></label>
                                        <ul class="list-group">

                                        <?php if(!empty($my_schools) && count($my_schools) > 0 ): ?>
                                            <?php $__currentLoopData = $my_schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset($school->school->schoolName) ): ?>
                                                    <li class="list-group-item"><?php echo e($school->school->schoolName); ?>  <?php if(session('school_id') && session('school_id') == $school->school->id): ?><span class="glyphicon glyphicon-ok pull-right"></span><?php endif; ?> <?php if($userDetail->userMeta->default_school == $school->school->id && $userDetail->userrole == 2 ): ?> <span class="pull-right">(P)</span><?php endif; ?> </li>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <li class="list-group-item"><?php echo app('translator')->getFromJson('general.norecords'); ?></li>
                                        <?php endif; ?>

                                        </ul>
                                    </div>

                                    <div class="form-group col-xs-12 <?php echo e($errors->has('userrole') ? ' has-error' : ''); ?>"  style="display: none;">
                                        <label><?php echo app('translator')->getFromJson('adminuser.userrole'); ?><em>*</em></label>
                                        <select class="selectpicker" name="userrole" id="userrole">
                                            <option value="" disabled="disabled"><?php echo app('translator')->getFromJson('adminuser.userrole'); ?></option>
                                            <?php if(isset($rolesList) && !empty($rolesList)): ?>
                                                <?php $__currentLoopData = $rolesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($role->rolename && $role->id != 1): ?>
                                                    <?php if($role->id == $userDetail->userrole): ?>
                                                            <option value="<?php echo e($role->id); ?>" <?php if(!empty($userDetail->userrole)): ?> <?php if($role->id == $userDetail->userrole): ?> selected="selected" <?php endif; ?> <?php else: ?>
                                                            <?php if(!empty(old('userrole'))): ?>
                                                            <?php if($role->id == old('userrole')): ?>
                                                            selected="selected"
                                                                    <?php endif; ?>
                                                                    <?php endif; ?>
                                                                    <?php endif; ?>
                                                            ><?php echo e($role->rolename); ?></option>
                                                        <?php endif; ?>
                                                   <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                        <?php if($errors->has('userrole')): ?>
                                            <span class="help-block">
                                            <strong><?php echo e($errors->first('userrole')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group col-xs-12 <?php echo e($errors->has('schoolId') ? ' has-error' : ''); ?>"  style="display: none;">
                                        <label><?php echo app('translator')->getFromJson('adminuser.selectschool'); ?><em>*</em></label>
                                        <select id="schoollist" class="selectpicker" name="schoolId[]" <?php if(!empty($userDetail) && ( $userDetail->userrole==2 || $userDetail->userrole==4 ) ): ?> multiple="multiple" <?php endif; ?> />
                                        <option disabled="disabled" value="" <?php if(empty($userDetail)): ?> selected="selected" <?php endif; ?> ><?php echo app('translator')->getFromJson('adminuser.selectschool'); ?></option>
                                        <?php if(!empty($schoolsList)): ?>
                                            <?php $__currentLoopData = $schoolsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($school->schoolName): ?>
                                                    <option value="<?php echo e($school->id); ?>" <?php if(!empty($user_schools)): ?> <?php if(in_array($school->id, $user_schools )): ?> selected="selected" <?php endif; ?> <?php else: ?> <?php if(!empty(old('schoolId'))): ?> <?php if($school->id == old('schoolId')): ?> selected="selected" <?php endif; ?> <?php endif; ?> <?php endif; ?> ><?php echo e($school->schoolName); ?></option>
                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                    </select>
                                                    <?php if($errors->has('schoolId')): ?>
                                                        <span class="help-block">
                                                        <strong><?php echo e($errors->first('schoolId')); ?></strong>
                                                    </span>
                                                    <?php endif; ?>
                                    </div>
                                    <?php if(isset($userDetail) && ( $userDetail->userrole == 2 || $userDetail->userrole == 4 || $userDetail->userrole == 6) ): ?>
                                    <div class="form-group col-xs-12 <?php echo e($errors->has('default_language') ? ' has-error' : ''); ?>">
                                        <label><?php echo app('translator')->getFromJson('general.select_language'); ?><em>*</em></label>
                                        <select id="default_language" class="selectpicker" name="default_language">
                                            <option value=""><?php echo app('translator')->getFromJson('general.select_language'); ?></option>
                                            <?php if(config('language.option')): ?>
                                                <?php $__currentLoopData = config('language.option'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php if(old('default_language') == $key): ?> selected <?php endif; ?> <?php if(!empty($userDetail->userMeta->language) && $userDetail->userMeta->language == $key): ?> selected  <?php endif; ?>><?php echo e($value); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                        <?php if($errors->has('default_language')): ?>
                                            <span class="help-block">
                                                        <strong><?php echo e($errors->first('default_language')); ?></strong>
                                                    </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="form-group pull-right">
                                <?php if(Auth::user()->userrole != 3): ?>
                                <button type="submit" name="submit" class="btn btn-vdesk"><?php if(isset($userDetail)): ?> <?php echo app('translator')->getFromJson('adminuser.update'); ?> <?php else: ?> <?php echo app('translator')->getFromJson('adminuser.add'); ?> <?php endif; ?></button>
                                <?php endif; ?>
                                <a class="btn btn-default btn-vdesk-light" href="<?php echo e(url(App::getLocale().'/'.generateUrlPrefix() )); ?>"><?php echo app('translator')->getFromJson('general.cancel'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
