<?php $__env->startSection('title', trans('messages.mainapp.menu.users')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.users')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.users')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel" style="float:left;width:100%;">
                
         <div class="queuetokenbox">  
                    <a style="float:left" class="btn-floating waves-effect waves-light tooltipped" href="<?php echo e(route('users.create')); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.add')); ?> <?php echo e(trans('messages.mainapp.menu.users')); ?>"><i class="mdi-content-add left"></i></a>
                    
    
       <ul id="tabs-swipe-demo" class="tabs">    
    <li class="tab"><a class="active" href="#tabname_doctor">Doctor</a></li>
    <li class="tab"><a href="#tabname_user">User</a></li>
    <li class="tab"><a href="#tabname_help">Help Desk</a></li>
    <li class="tab"><a href="#tabname_admin">Admin</a></li>
  </ul>
  <div id="tabname_doctor" class="col s12">
  <table id="doctor-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.username')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.parent_department')); ?></th>
                                <th><?php echo e(trans('messages.users.counter')); ?></th>
                                <th><?php echo e(trans('messages.users.attendance')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th style="width:63px"><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $userdoctordetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userdoctordetail): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($userdoctordetail->name); ?></td>
                                    <td><?php echo e($userdoctordetail->username); ?></td>
                                    <td><?php echo e($userdoctordetail->email); ?></td>
                                    <td> <?php if($userdoctordetail->department_id == ''): ?> <span style='color:red'>Not Allowted <span> <?php else: ?><?php echo e($userdoctordetail->department->name); ?> <?php endif; ?></td>
                                    <td> <?php if($userdoctordetail->counter_id == ''): ?> <span class='allottedroom'>Not Allowted <a href="<?php echo e(route('settings')); ?>#userId" >Allowted Room</a></span> <?php else: ?><?php echo e($userdoctordetail->counter->name); ?> <span class='changeroom'><a href="<?php echo e(route('settings')); ?>#userId" >Change Room</a> <?php endif; ?></td>
                                    <td><?php if($userdoctordetail->user_status == 1): ?> Active <?php else: ?> Inactive <?php endif; ?></td>
                                    <td><?php echo e($userdoctordetail->role_text); ?></td>
                                    <?php if($userdoctordetail->id==$user->id): ?>
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="<?php echo e(route('get_user_password', ['userdoctordetails' => $userdoctordetail->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.change')); ?> <?php echo e(trans('messages.users.password')); ?>"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="<?php echo e(route('users.destroy', ['userdoctordetails' => $userdoctordetail->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.delete')); ?>" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
  
  </div>
  <div id="tabname_user" class="col s12"> <table id="user-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.username')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.attendance')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th style="width:63px"><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $getalluserdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getalluserdetail): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($getalluserdetail->name); ?></td>
                                    <td><?php echo e($getalluserdetail->username); ?></td>
                                    <td><?php echo e($getalluserdetail->email); ?></td>
                                    <td><?php if($getalluserdetail->user_status == 1): ?> Active <?php else: ?> Inactive <?php endif; ?></td>
                                    <td><?php echo e($getalluserdetail->role_text); ?></td>
                                    <?php if($getalluserdetail->id==$user->id): ?>
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="<?php echo e(route('get_user_password', ['getalluserdetails' => $getalluserdetail->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.change')); ?> <?php echo e(trans('messages.users.password')); ?>"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="<?php echo e(route('users.destroy', ['getalluserdetails' => $getalluserdetail->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.delete')); ?>" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table> </div>

  <div id="tabname_help" class="col s12"> <table id="help-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.username')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.attendance')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th style="width:63px"><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $gethepdeskdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gethepdeskdetail): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($gethepdeskdetail->name); ?></td>
                                    <td><?php echo e($gethepdeskdetail->username); ?></td>
                                    <td><?php echo e($gethepdeskdetail->email); ?></td>
                                    <td><?php if($gethepdeskdetail->user_status == 1): ?> Active <?php else: ?> Inactive <?php endif; ?></td>
                                    <td><?php echo e($gethepdeskdetail->role_text); ?></td>
                                    <?php if($gethepdeskdetail->id==$user->id): ?>
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="<?php echo e(route('get_user_password', ['gethepdeskdetails' => $gethepdeskdetail->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.change')); ?> <?php echo e(trans('messages.users.password')); ?>"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="<?php echo e(route('users.destroy', ['gethepdeskdetails' => $gethepdeskdetail->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.delete')); ?>" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table> </div>

      <div id="tabname_admin" class="col s12"> <table id="admin-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th><?php echo e(trans('messages.name')); ?></th>
                                <th><?php echo e(trans('messages.users.username')); ?></th>
                                <th><?php echo e(trans('messages.users.email')); ?></th>
                                <th><?php echo e(trans('messages.users.attendance')); ?></th>
                                <th><?php echo e(trans('messages.users.role')); ?></th>
                                <th style="width:63px"><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $getadmindetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getadmindetail): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr<?php echo ($getadmindetail->id==$getadmindetail->id)?' class="orange lighten-4"':''; ?>>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($getadmindetail->name); ?></td>
                                    <td><?php echo e($getadmindetail->username); ?></td>
                                    <td><?php echo e($getadmindetail->email); ?></td>
                                    <td><?php if($getadmindetail->user_status == 1): ?> Active <?php else: ?> Inactive <?php endif; ?></td>
                                    <td><?php echo e($getadmindetail->role_text); ?></td>
                                    <?php if($getadmindetail->id==$user->id): ?>
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange disabled" href="javascript:void(0);"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red disabled" href="javascript:void(0);"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            <a class="btn-floating btn-action waves-effect waves-light orange tooltipped" href="<?php echo e(route('get_user_password', ['getadmindetails' => $getadmindetail->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.change')); ?> <?php echo e(trans('messages.users.password')); ?>"><i class="mdi-communication-vpn-key"></i></a>
                                            <a class="btn-floating btn-action waves-effect waves-light red tooltipped frmsubmit" href="<?php echo e(route('users.destroy', ['getadmindetails' => $getadmindetail->id])); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.delete')); ?>" method="DELETE"><i class="mdi-action-delete"></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table> </div>                                  


                   
                   

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
    <script>
        $(function() {
            $('#user-table, #doctor-table, #help-table, #admin-table').DataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }]
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>