<?php $__env->startSection('content'); ?>
<?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
              <?php if( $department->is_uhid_required == 1): ?>
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal2_<?php echo e($department->id); ?>"><?php echo e($department->name); ?> <sup style="color:#890202; font-size:15px">*</sup></a>
     <?php else: ?>
     <button style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="btn waves-effect waves-light csfloat" onclick="queue_dept(<?php echo e($department->id); ?>)" style="text-transform:none"><?php echo e($department->name); ?> </button>
     <?php endif; ?>

             
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>  

<?php $__env->stopSection(); ?>


