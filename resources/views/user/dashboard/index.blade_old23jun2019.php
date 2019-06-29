@extends('layouts.app')

@section('title', trans('messages.mainapp.menu.dashboard'))

@section('css')
    <link href="{{ asset('assets/css/materialize-colorpicker.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('assets/js/plugins/data-tables/css/jquery.dataTables.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
@endsection


@section('content')
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem">{{ trans('messages.mainapp.menu.dashboard') }}</h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li class="active">{{ trans('messages.mainapp.menu.dashboard') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="card-stats">
            @can('access', \App\Models\User::class)
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> {{ trans('messages.today_queue') }}</p>
                                <h4 class="card-stats-number">
                                <?php $today_total_patients_in_queue = '0'; $today_total_patients_called = '0'; $today_total_patients_in_waiting = '0'; $today_total_patients_to_doctor = '0' ?>
                               @foreach($today_queue as $quedetail)

                                @php( $today_total_patients_in_queue += count($quedetail->number) )

                                @if($quedetail->called==0)
                                @php( $today_total_patients_in_waiting += count($quedetail->number) )
                                @endif
                                
                                @if($quedetail->called==1)
                                @php( $today_total_patients_called += count($quedetail->number) )
                                @endif  
                                
                               @endforeach

                            
                              
                              
                                <ul class="ttissuedetails">
                               <li>Total : <span>{{$today_total_patients_in_queue}}</span></li>
                               <li>Waiting : <span>{{$today_total_patients_in_waiting}}</span></li>
                               <li>Missed : <span>{{$today_total_patients_called-count($getTodayAvgConsultingTime)}}</span></li>
                              
                               
                             </ul> 

                                </h4>
                                </p>
                            </div>
                            <div class="card-action light-blue darken-4">
                                <div class="center-align">
                                    <a href="{{ route('reports::queue_list', ['date' => \Carbon\Carbon::now()->format('d-m-Y')]) }}" style="text-transform:none;color:#fff">{{ trans('messages.more_info') }} <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content green lighten-1 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-communication-call-missed"></i> Toady Avg. Waiting Time</p>
                                <h4 class="card-stats-number">

                                <?php $tavg_start_w_time = '0'; $tavg_end_w_time = '0'; $tt_patients_w = '0'; $tt_avg_time_w='0'; $tttoken_w='0'  ?>
                                @foreach($getTodayAvgWaitingTime as $awaitingTime)
                                   
                                @php( $tavg_end_w_time += strtotime($awaitingTime->updated_at) )
                                @php( $tavg_start_w_time += strtotime($awaitingTime->created_at))
                                @php( $tt_patients_w += count($awaitingTime->number))
                                @endforeach
                             
                                <?php 
                                 if($tt_patients_w > 0){
                                    $tttoken_w = $tt_patients_w;
                                    //echo $tttoken.'<br>';
                                   }else{
                                    $tttoken_w  = 1;
                                   }
                                   $tt_avg_time_w = ($tavg_end_w_time-$tavg_start_w_time)/$tttoken_w;
                                  // echo $tt_avg_time_w;
                                   
                                 echo gmdate("H:i:s", $tt_avg_time_w).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                   
                                    ?>
                                
                                </h4>
                                </p>
                            </div>
                            <div class="card-action green darken-2">
                                <div class="center-align">
                    <a href="javascript:void(0)" style="text-transform:none;color:#fff">&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content blue-grey white-text">
                                <p class="card-stats-title truncate"><i class="mdi-action-trending-up"></i> Today Avg. Consulting Time</p>
                                <h4 class="card-stats-number">
                                <?php $tavg_start_time = '0'; $tavg_end_time = '0'; $tt_patients = '0'; $tt_avg_time='0';  ?>
                                @foreach($getTodayAvgConsultingTime as $aconsultingTime)
                                   
                                @php( $tavg_end_time += strtotime($aconsultingTime->doctor_work_end_date) )
                                @php( $tavg_start_time += strtotime($aconsultingTime->doctor_work_start_date))
                                @php( $tt_patients += count($aconsultingTime->number))
                                @endforeach
                               
                                <?php 
                                 if($tt_patients > 0){
                                    $tttoken = $tt_patients;
                                    //echo $tttoken.'<br>';
                                   }else{
                                    $tttoken  = 1;
                                   }
                                   $tt_avg_time = ($tavg_end_time-$tavg_start_time)/$tttoken;
                                   
                                 echo gmdate("H:i:s", $tt_avg_time).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                   
                                    ?>
                                
                                </h4>
                                </p>
                            </div>
                            <div class="card-action blue-grey darken-2">
                                <div class="center-align">
                        <a href="javascript:void(0);" style="text-transform:none;color:#fff">&nbsp; </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-image-timer"></i> Today Total Consultant(Seen)</p>
                                <h4 class="card-stats-number">{{ count($getTodayAvgConsultingTime) }}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);" style="text-transform:none;color:#fff">&nbsp;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('access', \App\Models\User::class)
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark teal lighten-3 white-text" style="display:inherit">
                            <span class="chart-title">{{ trans('messages.queue_details') }}</span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="queue-details-chart" height="155" style="height:308px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark" style="display:inherit">
                            <span class="chart-title">{{ trans('messages.today_yesterday') }}</span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="today-vs-yesterday-chart" height="155" style="height:308px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan


            @if($role == 'H')
			<div class="row">
					<div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors Active Today</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_present)}}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors Absent</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_absent)}}</h4>
                                </p>
                            </div>
                            <div class="card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>	
                <div class="row">
            <div class="col s12">
            
            <div class="queuetokenbox">  
            
       <ul id="tabs-swipe-demo" class="tabs">    
    <li class="tab"><a class="active" href="#tabname_doctor">Doctor</a></li>
    <li class="tab"><a href="#tabname_user">User</a></li>
  </ul>
  <div id="tabname_doctor" style="width:100%;">
            <h3 class="listdoctor">List Of Doctors</h3>
                <div class="cardp card-panel">
                    <table id="doctor-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $tuser)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tuser->name }}</td>
                                    <td>{{ $tuser->email }}</td>
                                    <td>
                                    @foreach($pardepartments as $pardepartment)
                                    @if( $tuser->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $tuser->department->name }}</td>
                                    <td>{{ $tuser->counter->name }}</td>
                                    <td>{{ $tuser->role_text }}</td>
                                  <td class="caction">
                                  @if($tuser->user_status == 1)
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  @else
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  @endif
                                 </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
<!------------------------------------------------>

<div id="tabname_user" style="width:100%;">
            <h3 class="listdoctor">List Of Users</h3>
                <div class="cardp card-panel">
                    <table id="user-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staffusers as $staffuser)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $staffuser->name }}</td>
                                    <td>{{ $staffuser->email }}</td>
                                    <td>{{ $staffuser->role_text }}</td>
                                  <td class="caction">
                                  @if($staffuser->user_status == 1)
                                  <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  @else
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                  @endif
                                 </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
               
               </div>


<!-------------------------------------------->

               </div>


            </div>
        </div>
    </div>
			@endif

			
			
			@if($role == 'S')
			<div class="row userdashboard">
            <ul id="tabs-swipe-demo" class="tabs">    
            <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content yellow darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Tokens Issued Today</p>
                                <h4 class="card-stats-number">{{count($get_all_department_total_queue_in_today)}}</h4>
                                </p>
                            </div>
                            <div class="card-action yellow darken-4">
                                <div class="center-align">
                                <a class="active" href="#tabname_queue">More Details <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
					
                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Tokens Called Today</p>
                                <h4 class="card-stats-number">{{count($get_all_department_total_called_in_today)}}</h4>
                                </p>
                            </div>
                            <div class="card-action pink darken-4">
                                <div class="center-align">
                                <a href="#tabname_called">More Details <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>

                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors Active Today</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_present)}}</h4>
                                </p>
                            </div>
                            <div class="card-action light-green darken-4">
                                <div class="center-align">
                                <a href="#tabname_dpresent">More Details <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
					
                    <li class="tab"> <div class="col s12 m12 l12">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Doctors InActive Today</p>
                                <h4 class="card-stats-number">{{count($totaldoctor_absent)}}</h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                <a href="#tabname_dabsent">More Details <i class="mdi-navigation-arrow-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div></li>
                   
                </ul>
      <!------------------------------>  
      <div class="usertablebox">
      <div id="tabname_queue" class="col s12 m12 l12">
      <div class="cardp card-panel">
         
                    <table id="queue-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.token_number') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($get_all_department_total_queue_in_today as $q)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>@foreach($pardepartments as $pardepartment)
                                    @if( $q->department->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach</td>
                           <td>{{$q->department->name}}</td>
                           <td>{{$q->department->letter}}{{$q->number}}</td>
                           </tr>
                       @endforeach    
                        </tbody>
                    </table>
                </div>

      </div>
      <div id="tabname_called" class="col s12 m12 l12">
      <div class="cardp card-panel">
                    <table id="called-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
								<th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.token_number') }}</th>
                                <th>{{ trans('messages.users.room_number') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($get_all_department_total_called_in_today as $c)
                           <tr>
                           <td>{{ $loop->iteration }}</td>
						   <td>@foreach($users as $uc)
                           @if( $c->counter_id == $uc->counter_id )
                           {{$uc->name}}
                           @endif
                           @endforeach</td>
                           <td>@foreach($pardepartments as $pardepartment)
                                    @if( $c->department->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach</td>
                           <td>{{$c->department->name}}</td>
                           <td>{{$c->department->letter}}{{$c->number}}</td>
                           <td>
                          @foreach($users as $uc)
                           @if( $c->counter_id == $uc->counter_id )
                           {{$uc->counter->name}}
                           @endif
                           @endforeach
                           </td>
                           </tr> 
                        @endforeach 
                        </tbody>
                    </table>
                </div>

      </div>
      <div id="tabname_dpresent" class="col s12 m12 l12">
      <div class="cardp card-panel">
                    <table id="dp-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $tuser)
                            @if($tuser->user_status == 1)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tuser->name }}</td>
                                    <td>{{ $tuser->email }}</td>
                                    <td>
                                    @foreach($pardepartments as $pardepartment)
                                    @if( $tuser->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $tuser->department->name }}</td>
                                    <td>{{ $tuser->counter->name }}</td>
                                    <td>{{ $tuser->role_text }}</td>
                                  <td class="caction">
                                <button class="btn waves-effect waves-light btn-small green">Active</button>
                                  </td>
                                    </tr>
                                    
                                  @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
      </div>
      <div id="tabname_dabsent" class="col s12 m12 l12">
       
      <div class="cardp card-panel">
                    <table id="da-table"  class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:40px">#</th>
                                <th>{{ trans('messages.name') }}</th>
                                <th>{{ trans('messages.users.email') }}</th>
                                <th>{{ trans('messages.users.parent_department') }}</th>
                                <th>{{ trans('messages.users.department') }}</th>
                                <th>{{ trans('messages.users.counter') }}</th>
                                <th>{{ trans('messages.users.role') }}</th>
                                <th>{{ trans('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $tuser)
                            @if($tuser->user_status == 2)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tuser->name }}</td>
                                    <td>{{ $tuser->email }}</td>
                                    <td>
                                    @foreach($pardepartments as $pardepartment)
                                    @if( $tuser->pid == $pardepartment->id )
                                    {{ $pardepartment->name }} @else @endif
                                    @endforeach
                                    </td>
                                    <td>{{ $tuser->department->name }}</td>
                                    <td>{{ $tuser->counter->name }}</td>
                                    <td>{{ $tuser->role_text }}</td>
                                  <td class="caction">
                                  <button class="btn waves-effect waves-light btn-small pink">InActive</button>
                                 </td>
                                </tr>
                               
                                @endif 
                            @endforeach
                        </tbody>
                    </table>
                </div> </div>
      </div>

      </div>            
                    
      <!------------------------------->              
                </div>	
			@endif
			
			@if($role == 'D')
           <!----------------------------------> 
            <div class="row">

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Department :</span><span>
           @if($pdepartments->id == '') <a style="color:red">Not Allotted</a>  @else {{$pdepartments->name}}  @endif
            </span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Sub Department :</span><span>@if($user_details->department_id == '') <a style="color:red">Not Allotted </a> @else {{$user_details->department->name}}   @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            <div class="doctordetails">
            <span>Room No. :</span><span>@if($user_details->counter_id == '') <a style="color:red">Not Allotted</a> @else {{$user_details->counter->name}}  @endif</span>
            </div></div>

            <div class="col s12 m6 l3">
            </div>

            </div>
           <!------------------------------------->
			<div class="row">
            <!---------------------->
             <div class="col s6 m6 l3 pd_right">
              <div class="card hoverable">
                            <div class="responsive_info card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patient Seen By You <span class="respan">Today</span> </p>
                                <h4 class="card-stats-number">{{ $patient_seen }}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!-------------------------> 

            <div class="col s6 m6 l3 pd_left">
              <div class="card hoverable">
                            <div class="responsive_info card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patient Called By You <span class="respan">Today</span></p>
                                <h4 class="card-stats-number">
                                {{count($patient_called_bydoctor)}}
                               <!-- {{count($today_called_bycounter)}}--->
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action pink darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 

            <!------------------------>
                    
            <div class="col s6 m6 l3 pd_right">
               <div class="card hoverable">
                            <div class="responsive_info card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Patients Pending</p>
                                <h4 class="card-stats-number">{{count($today_queue_bycounter)}}</h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action orange darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!--------------------------->
            <div class="col s6 m6 l3 pd_left">
                        <div class="card hoverable">
                            <div class="responsive_info card-content blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Average Time <span class="respan">(with patient)</span></p>
                                <h4 class="card-stats-number">
                               
                               <?php $total_end_time = '0'; $total_start_time = '0'; $total_token = '0'; $total_time_spent_for_patient; $ttpatient ?>
                               @foreach($daily_avgtime_of_doctor as $option)
                                @php( $total_end_time += strtotime($option->end_time) )
                                @php( $total_start_time += strtotime($option->start_time))
                               @endforeach
                            
                                <?php 
                               // echo $patient_seen.'<br>';
                               if($patient_seen > 0){
                                $ttpatient = $patient_seen;
                               }else{
                                $ttpatient = 1;
                               }
                                $total_time_spent_for_patient = ($total_end_time-$total_start_time)/$ttpatient;
                                 echo gmdate("H:i:s", $total_time_spent_for_patient).'<sub style="font-size:12px;">&nbsp; Hrs / Patient</sub>'; 
                                ?>
                                </h4>
                                </p>
                            </div>
                            <div class="responsive_card card-action blue darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>         
            <!------------------------->            
                </div>	
			@endif
			
			@if($role == 'D')
			<div class="row">
                <div class="col s12">
				<div class="card-panel doctordashboard">
                    
                    <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>
                    <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room No.</th>
								<th>Token</th>
                                <th>{{ trans('messages.actions') }}</th>
                                <th>Patient Called</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient_list_doctorwise->sortBy('number') as $patient)
                        <!---------------------------------------->   
                                <tr>
                                    <td @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif >{{ $loop->iteration }}</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>{{ $patient->counter->name  }}</td>
									<td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>{{$patient->department->letter}}{{ $patient->number  }}</td>
                                    <td  @if($patient->view_status == 1) class="enabled" @else class="disabled"  @endif>
                                    <?php
                                    if(in_array($patient->view_status, array(1,2))) {
                                        if($patient->doctor_work_start == 0){
                                    ?>
                                         <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="{{url('/dashboard/startCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.start_time') }}"> <i class="mdi-av-timer"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.you_do_first_start') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else if($patient->doctor_work_start == 1){
                                    ?>
                                    <a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="{{ trans('messages.You_have_started') }}"> <i class="mdi-av-timer"></i></a>

<a  class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="{{url('/dashboard/endCounter')}}/{{$patient->id}}" data-position="top" data-tooltip="{{ trans('messages.end_time') }}"> <i class="mdi-action-schedule"></i></a>
                                    <?php
                                        }else{
                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php
                                        }
                                    }else{

                                    ?>
                                     <a style="cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light deep-purple tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-action-schedule"></i></a>

<a style="cursor:not-allowed" class="disabled btn-floating waves-effect waves-light btn blue tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Press ON to display Patient Token Number"> <i class="mdi-av-timer"></i></a>
                                    <?php    
                                    }
                                    ?>
                                    </td>
                                  
                                  
                                  @if(in_array($patient->view_status, array(1,2)))
                                  <td>
                                  @if($patient->doctor_work_start == 1)     
                                  <a style="font-size:10px cursor:not-allowed" class="disabled btn-floating btn waves-effect waves-light green tooltipped" href="javascript:void(0)" data-position="top" data-tooltip="Not Allowed">ON</a>
                                  @else
                                
                                 <a style="font-size:10px" class="btn-floating btn waves-effect waves-light green tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn OFF ??">ON</a>

                                 @endif
                                 </td>
                                  
                                 <!--------->
                                  @else
                                  <td>  
                                 
                                  <a style="font-size:10px" class="btn-floating btn waves-effect waves-light red tooltipped" href="{{url('/dashboard/PatientStatus')}}/{{$patient->id}}" data-position="top" data-tooltip="Press to turn ON ??">OFF</a>
                                 </td>

                                  @endif

                                 </tr>
                         <!------------------>  
                            
                        
                         <!------------------>

                            @endforeach
                        </tbody>
                    </table>
                    
                <div class="row">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               <form id="new_call" action="{{ route('post_doctor_call') }}" method="post">
                            {{ csrf_field() }}
                            @if(!($user->is_admin)||($user->role=='D'))
                            <input type="hidden" name="user" value="{{ $user->id }}">
                            <input type="hidden" name="pid" value="{{ $user->pid }}">
                            <input type="hidden" name="department" value="{{ $user->department_id }}">
                            <input type="hidden" name="counter" value="{{ $user->counter_id }}">
                           @endif
                             <div class="row">
                                <div class="col s12">
                                    <button @if(count($patient_list_doctorwise) >= 6) disabled="disabled" @endif class="btn waves-effect waves-light pink" type="submit">
                                        {{ trans('messages.call.call_next') }}<i class="mdi-content-send right"></i></i>
                                    </button>
                                </div>
                            </div>
                        </form>
               <!------------------------------------>
                </div>
                </div>
                </div>
                    
                </div>
				</div>
			</div>
			@endif

            
			@if($role == 'A')
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable waves-effect waves-dark" style="display:inherit">
                        <div class="card-move-up black-text">
                            <div class="move-up">
                                <div>
                                    <span class="chart-title">{{ trans('messages.dashboard.notification') }}</span>
                                </div>
                                <div class="trending-line-chart-wrapper">
                                    <p>{{ trans('messages.dashboard.preview') }}:</p>
                                    <span style="font-size:{{ $setting->size }}px;color:{{ $setting->color }}">
                                        <marquee>{{ $setting->notification }}</marquee>
                                    </span>
                                    <p></p>
                                    <form id="noti" action="{{ route('dashboard_store') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="input-field col s12 m8">
                                                <label for="notification">{{ trans('messages.dashboard.notification_text') }}</label>
                                                <input id="notification" name="notification" type="text" placeholder="{{ trans('messages.dashboard.notification_placeholder') }}" data-error=".errorNotification" value="{{ $setting->notification }}">
                                                <div class="errorNotification"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <label for="size">{{ trans('messages.font_size') }}</label>
                                                <input id="size" name="size" type="number" placeholder="Size" max="60" min="15" size="2" data-error=".errorSize" value="{{ $setting->size }}">
                                                <div class="errorSize"></div>
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <label for="color">{{ trans('messages.color') }}</label>
                                                <input id="color" type="text" placeholder="Color" name="color" data-error=".errorColor" value="{{ $setting->color }}">
                                                <div class="errorColor"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <button class="btn waves-effect waves-light right submit" type="submit" style="padding:0 1.3rem">{{ trans('messages.go') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			@endif
		</div>
    </div>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/voice.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/materialize-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/chartjs/chart.min.js') }}"></script>  
    <script type="text/javascript" src="{{ asset('assets/js/plugins/data-tables/js/jquery.dataTables.min.js') }}"></script>
 
   
    <script>
        $(function() {
            $('#doctor-table').DataTable({
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

            $('#user-table').DataTable({
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


            $('#queue-table').DataTable({
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

            $('#called-table').DataTable({
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




            $('#dp-table').DataTable({
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

            $('#da-table').DataTable({
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

    <script>
        function nextPatient(){
            var bleep = new Audio();
            bleep.src = '{{ url('assets/sound/sound1.mp3') }}';
            bleep.play();
            window.setTimeout(function() {
         responsiveVoice.speak('Send Next Patient on counter number 2','UK English Female',{rate: 0.85});
        }, 1000); 
        }

        $(function() {
            $('#color').colorpicker();
        });

        @can('access', \App\Models\User::class)
            $("#noti").validate({
                rules: {
                    notification: {
                        required: true,
                        minlength: 5
                    },
                    size: {
                        required: true,
                        digits: true
                    },
                    color: {
                        required: true
                    }
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

           $(function() {
                var todayVsYesterdayCartData = {
                    labels: [@foreach ($counters as $indx => $counter)
                            @if($indx==0) <?php echo "'$counter->name'"; ?>
                            @else <?php echo ", '$counter->name'"; ?>
                            @endif
                        @endforeach],
                    datasets: [
                      {
                          label: "Today",
                          fillColor: "rgba(0,176,159,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(0,176,159,0.9)",
                          highlightStroke: "rgba(220,220,220,9)",
                          data: [@foreach ($today_calls as $indx => $today_call)
                                  @if($indx==0) <?php echo "'$today_call'"; ?>
                                  @else <?php echo ", '$today_call'"; ?>
                                  @endif
                              @endforeach]
                      },
                      {
                          label: "Yesterday",
                          fillColor: "rgba(151,187,205,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(151,187,205,0.9)",
                          highlightStroke: "rgba(220,220,220,0.9)",
                          data: [@foreach ($yesterday_calls as $indx => $yesterday_call)
                                  @if($indx==0) <?php echo "'$yesterday_call'"; ?>
                                  @else <?php echo ", '$yesterday_call'"; ?>
                                  @endif
                              @endforeach]
                      }
                    ]
                };
          
                var queueDetailsChartData = [
                  {
                      value: "{{ $today_total_patients_in_queue }}",
                      color: "#00c0ef",
                      highlight: "#00c0ef",
                      label: "Token Issued"
                  },
                  {
                      value: "{{ $today_total_patients_in_waiting }}",
                      color: "#00a65a",
                      highlight: "#00a65a",
                      label: "Waiting Patient"
                  },
                  {
                      value: "{{ $today_total_patients_called-count($getTodayAvgConsultingTime) }}",
                      color: "#f39c12",
                      highlight: "#f39c12",
                      label: "Missed Patients"
                  },
                  {
                      value: "{{ count($getTodayAvgConsultingTime) }}",
                      color: "#dd4b39",
                      highlight: "#dd4b39",
                      label: "Consultant"
                  }
                ];

                var todayVsYesterdayCart = new Chart($("#today-vs-yesterday-chart").get(0).getContext("2d")).Bar(todayVsYesterdayCartData,{
                    responsive:true
                });

                var queueDetailsChart = new Chart($("#queue-details-chart").get(0).getContext("2d")).Pie(queueDetailsChartData,{
                    responsive:true
                });
            });
        @endcan
    </script>
@endsection
