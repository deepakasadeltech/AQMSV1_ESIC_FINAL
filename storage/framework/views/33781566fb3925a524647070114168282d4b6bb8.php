<?php $__env->startSection('title', trans('messages.mainapp.menu.call')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.token_issue')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></a></li>
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.token_issue')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <div class="callingnone card">
                    <div class="card-content">
                        <span class="card-title" style="line-height:0;font-size:22px"><?php echo e(trans('messages.call.new_call')); ?></span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        <form id="new_call" action="<?php echo e(route('post_call')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                            <?php if(!$user->is_admin): ?>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="user"><?php echo e(trans('messages.call.user')); ?></label>
                                        <input id="user" type="hidden" name="user" value="<?php echo e($user->id); ?>" data-error=".user">
                                        <input type="text" data-error=".user" value="<?php echo e($user->name); ?>" readonly>
                                        <div class="user">
                                            <?php if($errors->has('user')): ?><div class="error"><?php echo e($errors->first('user')); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="user" class="active"><?php echo e(trans('messages.call.user')); ?></label>
                                        <select id="user" class="browser-default" name="user" data-error=".user">
                                            <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.call.user')); ?></option>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuser): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                             <option value="<?php echo e($cuser->id); ?>"<?php echo $cuser->id==old('user')?' selected':''; ?>>  
                              <?php if(($cuser->role=='S')||($cuser->role=='A')): ?>  <?php echo e($cuser->name); ?>

                              <?php if($cuser->role=='S'): ?> -(User)  <?php endif; ?> <?php if($cuser->role=='A'): ?> -(Admin)  <?php endif; ?>
                                <?php endif; ?>  
                             </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                        </select>
                                        <div class="user">
                                            <?php if($errors->has('user')): ?><div class="error"><?php echo e($errors->first('user')); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
							
							<div class="row">
                                <div class="input-field col s12">
                                    <label for="pid" class="active"><?php echo e(trans('messages.mainapp.menu.parent_department')); ?></label>
                                    <select id="pid" class="browser-default" name="pid" data-error=".pid">
                                        <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.parent_department')); ?></option>
                                        <?php $__currentLoopData = $pdepartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pdepartment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <?php if(session()->has('pid') && ($pdepartment->id==session()->get('pid'))): ?>
                                                <option value="<?php echo e($pdepartment->id); ?>" selected><?php echo e($pdepartment->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($pdepartment->id); ?>"><?php echo e($pdepartment->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </select>
                                    <div class="pid">
                                        <?php if($errors->has('pid')): ?><div class="error"><?php echo e($errors->first('pid')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="department" class="active"><?php echo e(trans('messages.mainapp.menu.department')); ?></label>
                                    <select id="department" class="browser-default" name="department" data-error=".department">
                                        <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.department')); ?></option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <?php if(session()->has('department') && ($department->id==session()->get('department'))): ?>
                                                <option value="<?php echo e($department->id); ?>" selected><?php echo e($department->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($department->id); ?>"><?php echo e($department->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </select>
                                    <div class="department">
                                        <?php if($errors->has('department')): ?><div class="error"><?php echo e($errors->first('department')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="counter" class="active"><?php echo e(trans('messages.mainapp.menu.counter')); ?></label>
                                    <select id="counter" class="browser-default" name="counter" data-error=".counter">
                                        <option value=""><?php echo e(trans('messages.select')); ?> <?php echo e(trans('messages.mainapp.menu.counter')); ?></option>
                                        <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <?php if(session()->has('counter') && ($counter->id==session()->get('counter'))): ?>
                                                <option value="<?php echo e($counter->id); ?>" selected><?php echo e($counter->name); ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo e($counter->id); ?>"><?php echo e($counter->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                    </select>
                                    <div class="counter">
                                        <?php if($errors->has('counter')): ?><div class="error"><?php echo e($errors->first('counter')); ?></div><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light right" type="submit">
                                        <?php echo e(trans('messages.call.call_next')); ?><i class="mdi-navigation-arrow-forward right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title" style="line-height:0;font-size:22px"><?php echo e(trans('messages.call.click_department')); ?></span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        <?php if($user->is_admin): ?>

                   <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>

                  
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal1_<?php echo e($department->id); ?>"><?php echo e($department->name); ?> <sup style="color:#890202; font-size:15px">*</sup></a>
     

                   <div id="modal1_<?php echo e($department->id); ?>" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4><?php echo e($department->name); ?></h4>
     <form id="dep_isuuetkn_<?php echo e($department->id); ?>" name="getValueform_<?php echo e($department->id); ?>" action="/" method="GET">
    <div class = "row">
    <div class="input-field col s12" style="display:none;">      
      <label>Enter Valid UHID :</label>
       <input class="uhid_<?php echo e($department->id); ?>" name="uhid" type="text" placeholder="UHID" value=""  />          
    </div>

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
<li><button class="btn waves-effect waves-light csfloat subbutton" onclick="call_dept(<?php echo e($department->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 
  <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
 
  <!--------------------------->

                 <?php else: ?> 

                  
         <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
    <?php if(($user->parent_id)==$department->parent_id): ?>

   
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="reloadclick waves-effect waves-light btn modal-trigger" href="#modal1_<?php echo e($department->id); ?>"><?php echo e($department->name); ?> <sup style="color:#890202; font-size:15px">*</sup></a>
     

     <?php endif; ?>
     
      

      <!------popup-start---------->     
     <div id="modal1_<?php echo e($department->id); ?>" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4><?php echo e($department->name); ?></h4>
     <form id="dep_isuuetkn_<?php echo e($department->id); ?>" name="getValueform_<?php echo e($department->id); ?>" action="/" method="GET">
    <div class = "row">
    <div class="input-field col s12" style="display:none;">      
      <label>Enter Valid UHID :</label>
       <input autocomplete="off" class="uhid_<?php echo e($department->id); ?>" name="uhid" type="text" placeholder="UHID" value=""  />          
    </div>

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
        
<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">Cancel</a></li>
<li class="reloadclick">  <button class="btn waves-effect waves-light csfloat subbutton" onclick="call_dept(<?php echo e($department->id); ?>); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none"><?php echo e(trans('messages.call.token_issue')); ?><i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 
  <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
  <?php endif; ?> 

                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content" style="font-size:14px">
                        <span class="card-title" style="line-height:0;font-size:22px"><?php echo e(trans('messages.call.todays_queue')); ?></span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        <table id="call-table" class="display" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(trans('messages.mainapp.menu.department')); ?></th>
                                    <th><?php echo e(trans('messages.call.number')); ?></th>
                                    <th><?php echo e(trans('messages.call.called')); ?></th>
                                    <th><?php echo e(trans('messages.mainapp.menu.counter')); ?></th>
                                    <th><?php echo e(trans('messages.call.recall')); ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
   
   <table style="width:100%; border:none; margin:0px; padding:0px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:block; text-transform:uppercase; font-size:18px;"><?php echo e(str_limit( $company_name)); ?></span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center; padding:5px 0;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:25px;">टोकन संख्या : <?php echo e(session()->get('number')); ?></span>

   <span style="display:block; font-weight:800; border-top:0px; border:2px dotted #000; color:#000; padding:4px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : <?php echo e(session()->get('registration_no')); ?></span>

  </td></tr>

  
   
   <tr><td colspan="2" style="padding:0px 3px; font-size:12px;" >
   <table style="width:100%; border:none; margin:0px; padding:0px; text-transform:uppercase; border-collapse:collapse;">
   <tr> <td style="width:70%; padding:4px; border:1px solid #ccc;">Department Name (विभाग<br> का नाम) <span style="float:right;">:</span></td> <td style="width:30%; padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('department_name')); ?></td> </tr>
    <?php if(session()->get('uhid') != ''): ?>
   <tr style="display:none;"> <td style="padding:4px; border:1px solid #ccc;">UHID No. (यूएचआईडी संख्या) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(session()->get('uhid')); ?></td> </tr>
   <?php else: ?>  <?php endif; ?>

   <tr> <td style="padding:4px; border:1px solid #ccc;">Patients in queue (कुल व्यक्ति प्रतीक्षा कर रहे हैं) <span style="float:right;">:</span></td>  <td style="padding:8px; border:1px solid #ccc;"><?php echo e(session()->get('total')-1); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Date (दिनांक) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"> <?php echo e(\Carbon\Carbon::now()->format('d-m-Y')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Time (समय) <span style="float:right;">:</span></td>  <td style="padding:4px; border:1px solid #ccc;"><?php echo e(\Carbon\Carbon::now()->format('h:i:s A')); ?></td> </tr>
   <tr> <td style="padding:4px; border:1px solid #ccc;">Token slip created by (टोकन पर्ची किसके द्वारा बनाई गई है) <span style="float:right;">:</span></td> <td style="padding:4px; border:1px solid #ccc;"> <strong>Self (KIOSK)
   </table>
   
   </td></tr>
   
   <tr><td colspan="2" style="padding:10px 10px; font-size:10px; text-align:left;">
   <h5 style="text-transform:uppercase; margin:0 0 0px 0px;">Please wait for your token No. on TV Display <br>(कृपया प्रदर्शन पर अपना टोकन नंबर जांचें)</h5>
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

    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js')); ?>"></script>
    
    <script>
    //-------------------------------
        $("#new_call").validate({
            rules: {
                user: {
                    required: true,
                    digits: true
                },
                pid: {
                    required: true,
                    digits: true
                },
				department: {
                    required: true,
                    digits: true
                },
                counter: {
                    required: true,
                    digits: true
                },
            },
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });

 //--------------------------
    

    //---------------------------

        function call_dept(value) {
            //$('body').removeClass('loaded');
			var uhid = $('.uhid_'+value).val();
            var registration = $('.registration_'+value).val();
			var priority = $('.priority_'+value+':checked').val();
			//alert(uhid + '---' + priority); return false;
			var myForm1 = '<form id="hidfrm1" action="<?php echo e(url('calls/dept')); ?>/'+value+'" method="post"><?php echo e(csrf_field()); ?>'+
  '<input type="text" name="uhid" value="'+ uhid +'">'+'<input type="text" name="registration" value="'+ registration +'">'+
  '<input type="text" name="priority" value="'+ priority +'">'+'</form>';
            $('body').append(myForm1);
			
            myForm1 = $('#hidfrm1');
            myForm1.submit();
            //-------------------
          // if(myForm1.submit()){
           // window.onload = function() {startTime() }
           // setTimeout(location.reload(), 1000);
            // }; 
            
            //----------------
        }
        

        function recall(call_id) {
            $('body').removeClass('loaded');
            var data = 'call_id='+call_id+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_recall')); ?>",
                data:data,
                cache:false,
                success: function(response) {
                    location.reload();
                }
            });
        }
		$('body').on('change', '#pid', function(){
			var options = "<option value=''>Select Parent Department</option>";
			if($(this).val() == ''){
				$('#department').html(options);
			}
			var data = 'pid='+$(this).val()+'&_token=<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:"POST",
                url:"<?php echo e(route('post_pdept')); ?>",
                data:data,
                cache:false,
				dataType:'json',
                success: function(resultJSON) {
					
					$.each(resultJSON, function(i, obj) {
					  //use obj.id and obj.name here, for example:
					  options += '<option value="'+obj.id+'">'+obj.name+'</option>';
					});
					$('#department').html(options);
										
                }
            });
		});

		
        $(function() {
            var calltable = $('#call-table').dataTable({
                "oLanguage": {
                    "sLengthMenu": "Show _MENU_",
                    "sSearch": "Search"
                },
                "columnDefs": [{
                    "targets": [ -1 ],
                    "searchable": false,
                    "orderable": false
                }],
                "ajax": "<?php echo e(url('assets/files/call')); ?>",
                "columns": [
                    { "data": "id" },
                    { "data": "department" },
                    { "data": "number" },
                    { "data": "called" },
                    { "data": "counter" },
                    { "data": "recall" }
                ]
            });

            setInterval(function(){
                calltable.api().ajax.reload(null,false);
            }, 3000);
        });

         //--------------------------------------
     var timer = '';
		function getRegistration(val, id)
		{  
			clearTimeout(timer);
			timer = setTimeout(function() {
					var data = 'regist='+val+'&_token=<?php echo e(csrf_token()); ?>';
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

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>