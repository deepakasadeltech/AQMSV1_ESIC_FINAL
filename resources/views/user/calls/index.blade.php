@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.call'))

@section('css')
    <link href="{{ asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
@endsection

@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">

        <div class="row">
        <div class="col s12 m12 l12">
        <!--------------------------------> 
  
   
  <div class="popupmain">
  @if(session()->has('department_name')) 
  <div class="popuptoken"> 
  <div class="tknpopupbox">
  टोकन संख्या : {{ session()->get('number') }}  ( {{ session()->get('registration_no') }} )
  </div>
  <div>
  @endif
 </div>
 <!--------------------------------> 
 </div>
        </div>

            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.token_issue') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li><a href="{{ route('dashboard') }}">{{ trans('messages.mainapp.menu.dashboard') }}</a></li>
                        <li class="active">{{ trans('messages.mainapp.menu.token_issue') }}</li>
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
                        <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.call.new_call') }}</span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        <form id="new_call" action="{{ route('post_call') }}" method="post">
                            {{ csrf_field() }}
                            @if(!$user->is_admin)
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="user">{{ trans('messages.call.user') }}</label>
                                        <input id="user" type="hidden" name="user" value="{{ $user->id }}" data-error=".user">
                                        <input type="text" data-error=".user" value="{{ $user->name }}" readonly>
                                        <div class="user">
                                            @if($errors->has('user'))<div class="error">{{ $errors->first('user') }}</div>@endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="input-field col s12">
                                        <label for="user" class="active">{{ trans('messages.call.user') }}</label>
                                        <select id="user" class="browser-default" name="user" data-error=".user">
                                            <option value="">{{ trans('messages.select') }} {{ trans('messages.call.user') }}</option>
                                            @foreach($users as $cuser)
                             <option value="{{ $cuser->id }}"{!! $cuser->id==old('user')?' selected':'' !!}>  
                              @if(($cuser->role=='S')||($cuser->role=='A'))  {{ $cuser->name }}
                              @if($cuser->role=='S') -(User)  @endif @if($cuser->role=='A') -(Admin)  @endif
                                @endif  
                             </option>
                                            @endforeach
                                        </select>
                                        <div class="user">
                                            @if($errors->has('user'))<div class="error">{{ $errors->first('user') }}</div>@endif
                                        </div>
                                    </div>
                                </div>
                            @endif
							
							<div class="row">
                                <div class="input-field col s12">
                                    <label for="pid" class="active">{{ trans('messages.mainapp.menu.parent_department') }}</label>
                                    <select id="pid" class="browser-default" name="pid" data-error=".pid">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.parent_department') }}</option>
                                        @foreach($pdepartments as $pdepartment)
                                            @if(session()->has('pid') && ($pdepartment->id==session()->get('pid')))
                                                <option value="{{ $pdepartment->id }}" selected>{{ $pdepartment->name }}</option>
                                            @else
                                                <option value="{{ $pdepartment->id }}">{{ $pdepartment->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="pid">
                                        @if($errors->has('pid'))<div class="error">{{ $errors->first('pid') }}</div>@endif
                                    </div>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="department" class="active">{{ trans('messages.mainapp.menu.department') }}</label>
                                    <select id="department" class="browser-default" name="department" data-error=".department">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.department') }}</option>
                                        @foreach($departments as $department)
                                            @if(session()->has('department') && ($department->id==session()->get('department')))
                                                <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                            @else
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="department">
                                        @if($errors->has('department'))<div class="error">{{ $errors->first('department') }}</div>@endif
                                    </div>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="counter" class="active">{{ trans('messages.mainapp.menu.counter') }}</label>
                                    <select id="counter" class="browser-default" name="counter" data-error=".counter">
                                        <option value="">{{ trans('messages.select') }} {{ trans('messages.mainapp.menu.counter') }}</option>
                                        @foreach($counters as $counter)
                                            @if(session()->has('counter') && ($counter->id==session()->get('counter')))
                                                <option value="{{ $counter->id }}" selected>{{ $counter->name }}</option>
                                            @else
                                                <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="counter">
                                        @if($errors->has('counter'))<div class="error">{{ $errors->first('counter') }}</div>@endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light right" type="submit">
                                        {{ trans('messages.call.call_next') }}<i class="mdi-navigation-arrow-forward right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.call.click_department') }}</span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        @if($user->is_admin)

                   @foreach($departments as $department)

                  
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal1_{{ $department->id }}">{{ $department->name }} <sup style="color:#890202; font-size:15px">*</sup></a>
     

                   <div id="modal1_{{ $department->id }}" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4>{{ $department->name }}</h4>
     <form id="dep_isuuetkn_{{ $department->id }}" name="getValueform_{{ $department->id }}" action="/" method="GET">
    <div class = "row">
    <div class="input-field col s12" style="display:none;">      
      <label>Enter Valid UHID :</label>
       <input class="uhid_{{ $department->id }}" name="uhid" type="text" placeholder="UHID" value=""  />          
    </div>

    <div class="input-field col s12">      
<div class="regboxx">
<span><input type="text" value="{{ $department->regcode }}<?php echo date('m').substr(date('Y'),2); ?>" readonly disabled  /></span>
<span>
<label>Enter Your Number :</label>
<input autocomplete="off" class="registration_{{ $department->id }} regvalues" style="color:#777;" name="registration" type="text" placeholder="" value="" onkeyup="getRegistration(this.value, {{ $department->id }});" /></span> 
</div>         
</div>

<div class="col s12 checkregist">
         <ul>
         <li style="font-size:0.8rem">Valid: <span id="registlbl_{{ $department->id }}"></span></li>
         </ul>
          </div> 
               
         <div class="col s12" style="display:none;">
         <ul>
         <li style="font-size:0.8rem">Priority :</li>
         <li>
      <label>
        <input class="priority_{{ $department->id }}" name="priority" type="radio" value="1"  />
        <span>Y</span>
      </label>
    </li>
    <li>
      <label>
        <input class="priority_{{ $department->id }}" name="priority" type="radio" value="0" checked />
        <span>N</span>
      </label>
    </li></ul>
          </div>      
       
       </div>
       </form>
       <div class="modal-footer">
         <ul>
        
<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">{{ trans('messages.call.cancel') }}</a></li>
<li><button class="btn waves-effect waves-light csfloat subbutton" onclick="call_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ trans('messages.call.token_issue') }}<i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 
  @endforeach
 
  <!--------------------------->

                 @else 

                  
         @foreach($departments as $department)
    @if(($user->parent_id)==$department->parent_id)

   
     <a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="reloadclick waves-effect waves-light btn modal-trigger" href="#modal1_{{ $department->id }}">{{ $department->name }} <sup style="color:#890202; font-size:15px">*</sup></a>
     

     @endif
     
      

      <!------popup-start---------->     
     <div id="modal1_{{ $department->id }}" class="modal">
    <div class="modal-content">
    <div class="customform">
     <h4>{{ $department->name }}</h4>
     <form id="dep_isuuetkn_{{ $department->id }}" name="getValueform_{{ $department->id }}" action="/" method="GET">
    <div class = "row">
    <div class="input-field col s12" style="display:none;">      
      <label>Enter Valid UHID :</label>
       <input autocomplete="off" class="uhid_{{ $department->id }}" name="uhid" type="text" placeholder="UHID" value=""  />          
    </div>

    <div class="input-field col s12">      
<div class="regboxx">
<span><input type="text" value="{{ $department->regcode }}<?php echo date('m').substr(date('Y'),2); ?>" readonly disabled  /></span>
<span>
<label>Enter Your Number :</label>
<input autocomplete="off" class="registration_{{ $department->id }} regvalues" style="color:#777;" name="registration" type="text" placeholder="" value="" onkeyup="getRegistration(this.value, {{ $department->id }});" /></span> 
</div>         
</div>

<div class="col s12 checkregist">
         <ul>
         <li style="font-size:0.8rem">Valid: <span id="registlbl_{{ $department->id }}"></span></li>
         </ul>
          </div> 
               
         <div class="col s12" style="display:none;">
         <ul>
         <li style="font-size:0.8rem">Priority :</li>
         <li>
      <label>
        <input class="priority_{{ $department->id }}" name="priority" type="radio" value="1"  />
        <span>Y</span>
      </label>
    </li>
    <li>
      <label>
        <input class="priority_{{ $department->id }}" name="priority" type="radio" value="0" checked />
        <span>N</span>
      </label>
    </li></ul>
          </div>      
       
       </div>
       </form>
       <div class="modal-footer">
         <ul>
        
<li><a href="javascript:void(0)" class="modal-close waves-light btn red csfloat">Cancel</a></li>
<li class="reloadclick">  <button class="btn waves-effect waves-light csfloat subbutton" onclick="call_dept({{ $department->id }}); this.style.visibility='hidden'; this.disable=true;" style="text-transform:none">{{ trans('messages.call.token_issue') }}<i class="mdi-navigation-arrow-forward right"></i>
</button></li>
</ul>
   </div>
                      
        </div>
       
    </div>
   
  </div> 
  @endforeach
  @endif 

                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content" style="font-size:14px">
                        <span class="card-title" style="line-height:0;font-size:22px">{{ trans('messages.call.todays_queue') }}</span>
                        <div class="divider" style="margin:10px 0 10px 0"></div>
                        <table id="call-table" class="display" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('messages.mainapp.menu.department') }}</th>
                                    <th>{{ trans('messages.call.number') }}</th>
                                    <th>{{ trans('messages.call.called') }}</th>
                                    <th>{{ trans('messages.mainapp.menu.counter') }}</th>
                                    <th>{{ trans('messages.call.recall') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('print')
    @if(session()->has('department_name'))
        <style>#printarea{display:none;text-align:left}@media print{#loader-wrapper,header,#main,footer,#toast-container{display:none}#printarea{display:block;}}@page{margin:0}</style>
<div id="printarea" style="background:#ffffff; -webkit-print-color-adjust:exact; font-family: 'Open Sans', sans-serif; line-height:1.2;  position:relative;">
          <!------------------>     
          @if(session()->get('uhid') != '')
			<span style="position:absolute; top:0px; right:0px; font-size:10px; color:black; display:none;">
               @if(session()->get('priority') == '1') Y @else  N  @endif
               </span>@else @endif
   
   <table style="width:100%; border:none; padding:0px; font-size:11px;">
   <tr><td colspan="2" style="text-align:center">
   <h1 style="display:inline-table; margin:0px;">
   <span style="display:block; text-transform:uppercase; font-size:12px;">{{str_limit( $company_name)}}</span></h1></td></tr>
   
   <tr><td colspan="2" style="text-align:center;"><span style="display:inline-table; font-weight:800; border:2px dotted #000; color:#000; padding:1px; text-transform:uppercase; font-size:25px;">टोकन संख्या : {{ session()->get('number') }}</span>

   <span style="display:block; font-weight:800; border-top:0px; text-align:center; border-top:none; border:1px dotted #000; color:#000; padding:2px; text-transform:uppercase; font-size:12px;">पंजीकरण संख्या : {{ session()->get('registration_no') }}</span>
  </td></tr>

  <tr> <td style="padding:0px; border:1px solid #ccc; text-align:center;">{{ \Carbon\Carbon::now()->format('d-m-Y') }} {{ \Carbon\Carbon::now()->format('h:i:s A') }}</td> <td style="padding:0px; border:1px solid #ccc; text-align:center;">{{ session()->get('department_name') }}</td> </tr>

   <tr><td colspan="2" style="text-align:center; font-size:8px; padding:0 0 0px 0"><p style="margin:0px; padding:0px">Powered by <strong>ASADELTECH<sup>&reg;</sup><strong></p></td></tr>
   
   </table>

        <!--------------------->
        </div>
		@if(session()->get('printFlag'))
			<script>
				window.onload = function(){window.print();}
			</script>
		@endif	
        
    @endif
@endsection

@section('script')

    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script>
    
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
			var myForm1 = '<form id="hidfrm1" action="{{ url('calls/dept') }}/'+value+'" method="post">{{ csrf_field() }}'+
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
            var data = 'call_id='+call_id+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_recall') }}",
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
			var data = 'pid='+$(this).val()+'&_token={{ csrf_token() }}';
            $.ajax({
                type:"POST",
                url:"{{ route('post_pdept') }}",
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
                "ajax": "{{ url('assets/files/call') }}",
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
					var data = 'regist='+val+'&_token={{ csrf_token() }}';
					$.ajax({
						type:"POST",
						url:"{{ route('post_registration') }}",
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
@endsection
