<?php $__env->startSection('title', trans('messages.issue').' '.trans('messages.display.token')); ?>

<?php $__env->startSection('css'); ?>
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
                <div class="queue_time">  <span></span> <span><?php date_default_timezone_set('Asia/Kolkata'); echo date("l"); ?></span><span><?php date_default_timezone_set('Asia/Kolkata'); echo date("d.m.Y"); ?></span>
                <span id="gtime"> <?php date_default_timezone_set('Asia/Calcutta');$h = date('H'); $a = $h >= 12 ? 'PM' : 'AM';
             echo $timestamp = date('h:i:s ').$a; ?> </span> </div>
                <div class="queue_time"><span>Click on Department to get token Number <br> टोकन नंबर पाने के लिए विभाग पर क्लिक करें</span> <span style=display:none;></span><span style=display:none;></span></div>
                <div class="boxdept" id="token_section">

                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
              
     <a  style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal2_<?php echo e($department->id); ?>"><?php echo e($department->name); ?> <sup style="color:#890202; font-size:15px">*</sup></a>
    

               <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                 </div>
                </div>
                </div>
<!------------------------------------------>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
<div id="modal2_<?php echo e($department->id); ?>" class="modal">
<div class="modal-content">
<div class="customform">
<h4><?php echo e($department->name); ?></h4>
<form id="dep_isuuetkn2_<?php echo e($department->id); ?>" name="getValueform2_<?php echo e($department->id); ?>" action="/" method="GET">
<div class = "row">
<?php if( $department->is_uhid_required == 1): ?>
<div class="input-field col s12" style="display:none;">      
<label>Enter Valid UHID :</label>
<input autocomplete="off" class="uhid_<?php echo e($department->id); ?> keyboard" style="color:#777;" name="uhid" type="text" placeholder="UHID" value=""  />          
</div> <?php endif; ?>

<div class="input-field col s12">      
<div class="regboxx">
<span><input type="text" value="<?php echo e($department->regcode); ?><?php echo date('m').substr(date('Y'),2); ?>" readonly disabled  /></span>
<span>
<label>Enter Your Number :</label>
<input autocomplete="off" class="registration_<?php echo e($department->id); ?> regvalues" style="color:#777;" name="registration" type="text" placeholder="" value="" onkeyup="getRegistration(this.value, <?php echo e($department->id); ?>);" /></span> 
</div>         
</div>

<div class="col s12 checkregist">
         <ul>
         <li style="font-size:0.8rem">Valid: <span id="registlbl_<?php echo e($department->id); ?>"></span></li>
         </ul>
          </div> 

<div class="col s12" style="display:none;">
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
<li> <button class="btn waves-effect waves-light csfloat subbutton" onclick="queue_dept(<?php echo e($department->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
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
          <?php if(session()->get('uhid') != ''): ?>
			<span style="position:absolute; top:0px; right:0px; font-size:10px; color:black; display:none;">
               <?php if(session()->get('priority') == '1'): ?> Y <?php else: ?>  N  <?php endif; ?>
               </span><?php else: ?> <?php endif; ?>
   
  <table style="width:100%; border:none; padding:0px; font-size:11px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:block; text-transform:uppercase; font-size:12px;"><?php echo e(str_limit( $settings->name)); ?></span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:1px; text-transform:uppercase; font-size:25px;">टोकन संख्या : <?php echo e(session()->get('number')); ?></span>

   <span style="display:block; font-weight:800; border-top:0px; text-align:center; border-top:none; border:1px dotted #000; color:#000; padding:2px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : <?php echo e(session()->get('registration_no')); ?></span>
  </td></tr>

  <tr> <td style="padding:0px; border:1px solid #ccc; text-align:center;"><?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?> <?php echo e(\Carbon\Carbon::now()->format('h:i:s A')); ?></td> <td style="padding:0px; border:1px solid #ccc; text-align:center;"><?php echo e(session()->get('department_name')); ?></td> </tr>

   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 0px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
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
<script src="<?php echo e(url('assets/js/click_security.js')); ?>" type="text/javascript" ></script>
<script type="text/javascript">
//---------------------------------
//-----------------------


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
           var registration = $('.registration_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
			//alert(uhid + '---' + priority); return false;
            var myForm2 = '<form id="hidfrm2" action="<?php echo e(route('post_add_to_queue')); ?>" method="post"><?php echo e(csrf_field()); ?><input type="hidden" name="department" value="'+value+'">'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="registration" value="'+ registration +'">'+
  '<input type="text" name="priority" value="'+ priority +'">'+'</form>';
            $('body').append(myForm2);
            myForm2 = $('#hidfrm2');
            myForm2.submit();
        }

        function refreshtoken()
        {
            var data = 'type=refresh&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                data:data,
                url:"<?php echo e(route('refresh_token')); ?>",
                success: function(result) {
					$('#token_section').html(result);
				}
            });
        }

        window.setInterval(function() {			
           // refreshtoken();
           window.location.reload();
        }, 300000);

//----------------------------

     //--------------------------------------
     var timer = '';
		function getRegistration(val, id)
		{  
			clearTimeout(timer);
			timer = setTimeout(function() {
					var data = 'registration='+val+'&_token=<?php echo e(csrf_token()); ?>';
					$.ajax({
						type:"POST",
						url:"<?php echo e(route('post_registration')); ?>",
						data:data,
						cache:false,
						beforeSend: function(){
							$('#registlbl_'+id).html('Validating...');	
						},
						success: function(result) {							
							$('#registlbl_'+id).html(result);												
						}
					});
			}, 1000);
		}
   

//-------------------------------------------



$(document).ready(function(){

    $('.subbutton').attr('disabled',true);
    $('.regvalues').keyup(function(){
        if($(this).val().length !=0 && $(this).val().length >=5 && $(this).val().length < 6 ){
            $('.subbutton').attr('disabled',false);
        }else{
            $('.subbutton').attr('disabled',true);
        }
    })
     
});

//------------------------------------------


        
     
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainappqueue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>