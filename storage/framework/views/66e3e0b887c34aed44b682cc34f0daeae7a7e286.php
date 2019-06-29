<?php $__env->startSection('title', trans('messages.issue').' '.trans('messages.display.token')); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(url('assets/keyboard/css/keyboard.css')); ?>" type="text/css" rel="stylesheet" >
<link href="<?php echo e(url('assets/keyboard/css/jquery-ui.css')); ?>" type="text/css" rel="stylesheet" >
    <style>
        .btn-queue{padding:25px;font-size:47px;line-height:36px;height:auto;margin:10px;letter-spacing:0;text-transform:none}
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col s12">
            <div class="card" style="background:#f9f9f9;box-shadow:none">
                <span class="card-title" style="line-height:0;font-size:22px"><?php echo e(trans('messages.call.click_department')); ?></span>
                <div class="divider" style="margin:10px 0 10px 0"></div>
<!----------------------------------------------------->
                 <div class="addtoqueuesection">
                <div class="queuetokenbox">
                <div class="queue_time"><span>Click on Token Issue for get token Number</span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("l"); ?></span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("d.m.Y"); ?></span><span id="globaltime"></span></div>
               <!-- <?php $__currentLoopData = $getdepartmentbydoctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getdepartmentbydoctor): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>  <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>-->
    
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
              <?php if( $department->is_uhid_required == 1): ?>
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal2_<?php echo e($department->id); ?>"><?php echo e($department->name); ?> <sup style="color:#890202; font-size:15px">*</sup></a>
     <?php else: ?>
     <button style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="btn waves-effect waves-light csfloat" onclick="queue_dept(<?php echo e($department->id); ?>)" style="text-transform:none"><?php echo e($department->name); ?> 
     <?php endif; ?>
</button>
             
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </div>
                </div>
<!------------------------------------------>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
<div id="modal2_<?php echo e($department->id); ?>" class="modal">
<div class="modal-content">
<div class="customform">
<h4><?php echo e($department->name); ?> <span id="changelg" class="chooselang"> <label> <input name="langk" type="radio" value="hindi"  />
        <span>हिंदी</span> </label> <label> <input name="langk" type="radio" value="bengali-qwerty-1" checked  /> <span>ENGLISH</span>
      </label></span> </h4>
<form id="dep_isuuetkn2_<?php echo e($department->id); ?>" name="getValueform2_<?php echo e($department->id); ?>" action="/" method="GET">
<div class = "row">
<div class="input-field col s12">      
<label>Veritas UHID :</label>
<input class="uhid_<?php echo e($department->id); ?> keyboard" style="color:#777;" name="uhid" type="text" placeholder="UHID" value=""  />          
</div>

<div class="col s12">
<ul>
<li style="font-size:0.8rem">Priority :</li>
<li>
<label>
<input class="priority_<?php echo e($department->id); ?>" name="priority" type="radio" value="1"  />
<span>Y</span>
</label>
</li>
<li>
<label>
<input class="priority_<?php echo e($department->id); ?>" name="priority" type="radio" value="0" checked />
<span>N</span>
</label>
</li></ul>
</div>      

</div>
</form>
<div class="modal-footer">
<ul>

<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat"><?php echo e(trans('messages.call.cancel')); ?></a></li>
<li>  <button class="btn waves-effect waves-light csfloat" onclick="queue_dept(<?php echo e($department->id); ?>)" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
</div>
   
</div>

</div>

</div> 

  <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('print'); ?>
    <?php if(session()->has('department_name')): ?>
    <style>#printarea{display:none;text-align:left}@media  print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#f2f2f2; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
        
			<span style="position:absolute; top:0px; right:0px; font-size:7px; color:black;">
               <?php if(session()->get('priority') == '1'): ?> Y <?php else: ?>  N  <?php endif; ?>
               </span>
   
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:block; text-transform:uppercase; font-size:14px;"><?php echo e(str_limit( $settings->name, 14)); ?></span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; border:1px dotted #333; padding:4px; text-transform:uppercase; font-size:15px;">TOKEN NO : <?php echo e(session()->get('number')); ?></span></td></tr>
   
   <tr><td colspan="2" style="padding:0px; font-size:7px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">
   <tr> <td style="padding:4px; border:1px solid #ccc;">Department Name <span style="float:right;">:</span></td> <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('department_name')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">UHID Number <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('uhid')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Total Customer (s) Waiting <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;"><?php echo e(session()->get('total')-1); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> <?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(\Carbon\Carbon::now()->format('h:i:s A')); ?></td> </tr>
   </table>
   
   </td></tr>
   
   <tr><td colspan="2" style="padding:10px 0 0 0px; font-size:9px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Pl. check your Token No. on display</h5>
   </td></tr>
   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 10px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>


        <!--------------------->
        </div>
        <?php if(session()->get('printFlag')): ?>
			<script>
				window.onload = function(){window.print();}
			</script>
		<?php endif; ?>	
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script src="<?php echo e(url('assets/keyboard/js/jquery.keyboard.js')); ?>" type="text/javascript" ></script>
<script src="<?php echo e(url('assets/keyboard/js/jquery.mousewheel.js')); ?>" type="text/javascript" ></script>
<script src="<?php echo e(url('assets/keyboard/js/jquery.keyboard.extension-typing.js')); ?>" type="text/javascript" ></script>
<script src="<?php echo e(url('assets/keyboard/js/jquery.keyboard.extension-autocomplete.js')); ?>" type="text/javascript" ></script>
<script src="<?php echo e(url('assets/keyboard/js/bengali.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/keyboard/js/hindi.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
//---------------------------------

$(function () {
   

$('.keyboard').keyboard()
.addTyping({
showTyping: true,
delay: 50
});


$('#changelg label input').on('change', function() {
   //alert($('input[name="langk"]:checked').val()); 
   var layout = $('input[name="langk"]:checked').val();
$('.keyboard').each(function(){
    var kb = $(this).data('keyboard');
    kb.options.layout = layout;
    if (kb.$keyboard.length) {
        kb.reveal(true);
    }
});

}).change(); 



}); 
//-----------------------------------   
</script>

    <script type="text/javascript">
        $(function() {
            $('#main').css({'min-height': $(window).height()-134+'px'});
        });
        $(window).resize(function() {
            $('#main').css({'min-height': $(window).height()-134+'px'});
        });
        function queue_dept(value) {
           // $('body').removeClass('loaded');
		   var uhid = $('.uhid_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
			//alert(uhid + '---' + priority); return false;
            var myForm2 = '<form id="hidfrm2" action="<?php echo e(route('post_add_to_queue')); ?>" method="post"><?php echo e(csrf_field()); ?><input type="hidden" name="department" value="'+value+'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+
  '<input type="text" name="priority" value="'+ priority +'">'+'</form>';
            $('body').append(myForm2);
            myForm2 = $('#hidfrm2');
            myForm2.submit();
        }


      
     
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainappqueue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>