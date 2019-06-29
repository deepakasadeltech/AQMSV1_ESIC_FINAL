<?php $__env->startSection('title', trans('messages.mainapp.menu.dashboard')); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('assets/css/materialize-colorpicker.min.css')); ?>" type="text/css" rel="stylesheet" media="screen,projection">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="breadcrumbs-wrapper">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title col s5" style="margin:.82rem 0 .656rem"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></h5>
                    <ol class="breadcrumbs col s7 right-align">
                        <li class="active"><?php echo e(trans('messages.mainapp.menu.dashboard')); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div id="card-stats">
            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
                <div class="row">
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> <?php echo e(trans('messages.today_queue')); ?></p>
                                <h4 class="card-stats-number"><?php echo e($today_queue); ?></h4>
                                </p>
                            </div>
                            <div class="card-action light-blue darken-4">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::queue_list', ['date' => \Carbon\Carbon::now()->format('d-m-Y')])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content green lighten-1 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-communication-call-missed"></i> <?php echo e(trans('messages.today_missed')); ?></p>
                                <h4 class="card-stats-number"><?php echo e($missed); ?></h4>
                                </p>
                            </div>
                            <div class="card-action green darken-2">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'missed'])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content blue-grey white-text">
                                <p class="card-stats-title truncate"><i class="mdi-action-trending-up"></i> <?php echo e(trans('messages.today_served')); ?></p>
                                <h4 class="card-stats-number"><?php echo e($served); ?></h4>
                                </p>
                            </div>
                            <div class="card-action blue-grey darken-2">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'all'])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-image-timer"></i> <?php echo e(trans('messages.over_time')); ?></p>
                                <h4 class="card-stats-number"><?php echo e($overtime); ?></h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="<?php echo e(route('reports::missed_show', ['date' => \Carbon\Carbon::now()->format('d-m-Y'), 'user' => 'all', 'counter' => 'all', 'type' => 'overtime'])); ?>" style="text-transform:none;color:#fff"><?php echo e(trans('messages.more_info')); ?> <i class="mdi-navigation-arrow-forward"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark teal lighten-3 white-text" style="display:inherit">
                            <span class="chart-title"><?php echo e(trans('messages.queue_details')); ?></span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="queue-details-chart" height="155" style="height:308px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m6 l6">
                        <div class="card-panel hoverable waves-effect waves-dark" style="display:inherit">
                            <span class="chart-title"><?php echo e(trans('messages.today_yesterday')); ?></span>
                            <div class="trending-line-chart-wrapper">
                                <canvas id="today-vs-yesterday-chart" height="155" style="height:308px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

			
			
			<?php if($role == 'S'): ?>
			<div class="row">
					<div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Today Token Issed</p>
                                <h4 class="card-stats-number">0</h4>
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
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Today Token Called</p>
                                <h4 class="card-stats-number">0</h4>
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
			<?php endif; ?>
			
			<?php if($role == 'D'): ?>
			<div class="row">
            <!---------------------->

            <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content pink darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Department Detail</p>
                                <ul class="card-stats-number doctordetails">
                                <li>Department Name</li>
                                <li>Sub Department Name</li>
                                <li>Counter No.</li>
                                </ul>
                                </p>
                            </div>
                            <div class="card-action pink darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 

            <!------------------------>
                    <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content light-green darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Today Patient Seen</p>
                                <h4 class="card-stats-number"><?php echo e($patient_seen); ?></h4>
                                </p>
                            </div>
                            <div class="card-action light-green darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!-------------------------> 
            <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content orange darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i>Today Patient Pending For Call</p>
                                <h4 class="card-stats-number"><?php echo e(count($patient_list)); ?></h4>
                                </p>
                            </div>
                            <div class="card-action orange darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> 
            <!--------------------------->
            <div class="col s12 m6 l3">
                        <div class="card hoverable">
                            <div class="card-content blue darken-2 white-text">
                                <p class="card-stats-title truncate"><i class="mdi-social-group-add"></i> Doctor Average Time</p>
                                <h4 class="card-stats-number">

                               8 Hrs / Day
                               <!-- <?php $__currentLoopData = $daily_avgtime_of_doctor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dct): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <?php echo e(strtotime($dct->end_time)-strtotime($dct->start_time)); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>-->
                                </h4>
                                </p>
                            </div>
                            <div class="card-action blue darken-4">
                                <div class="center-align">
                                    <a href="javascript:void(0);"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>         
            <!------------------------->            
                </div>	
			<?php endif; ?>
			
			<?php if($role == 'D'): ?>
			<div class="row">
                <div class="col s12">
				<div class="card-panel doctordashboard">
                    
                    <div class="divider" style="margin:15px 0 10px 0; display:none;"></div>
                    <table id="department-table" class="display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Counter</th>
								<th>Token</th>
                                <th><?php echo e(trans('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $patient_list->sortBy('number'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($patient->counter->name); ?></td>
									<td><?php echo e($patient->department->letter); ?>-<?php echo e($patient->number); ?></td>
                                    <td>
										<?php if($patient->doctor_work_start == 0): ?>
                                        <a class="btn-floating waves-effect waves-light btn blue tooltipped" href="<?php echo e(url('/dashboard/startCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.start_time')); ?>"> <i class="mdi-av-timer"></i></a>
										<?php endif; ?>
										
										<?php if($patient->doctor_work_end == 0): ?>
                                        <a class="btn-floating btn waves-effect waves-light deep-purple tooltipped" href="<?php echo e(url('/dashboard/endCounter')); ?>/<?php echo e($patient->id); ?>" data-position="top" data-tooltip="<?php echo e(trans('messages.end_time')); ?>"> <i class="mdi-action-schedule"></i></a>
										<?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </tbody>
                    </table>
                    
                <div class="row">
                <div class="col s12 center">
                <div class="nextbuttoncall">
               <!------------------------------------>
               <form id="new_call" action="<?php echo e(route('post_doctor_call')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                            <?php if(!($user->is_admin)||($user->role=='D')): ?>
                            <input type="hidden" name="user" value="<?php echo e($user->id); ?>">
                            <input type="hidden" name="pid" value="<?php echo e($user->pid); ?>">
                            <input type="hidden" name="department" value="<?php echo e($user->department_id); ?>">
                            <input type="hidden" name="counter" value="<?php echo e($user->counter_id); ?>">
                           <?php endif; ?>
                             <div class="row">
                                <div class="col s12">
                                    <button <?php if(count($patient_list) >= 3): ?> disabled="disabled" <?php endif; ?> class="btn waves-effect waves-light pink" type="submit">
                                        <?php echo e(trans('messages.call.call_next')); ?><i class="mdi-content-send right"></i></i>
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
			<?php endif; ?>

            
			<?php if($role == 'A'): ?>
            <div class="row">
                <div class="col s12">
                    <div class="card hoverable waves-effect waves-dark" style="display:inherit">
                        <div class="card-move-up black-text">
                            <div class="move-up">
                                <div>
                                    <span class="chart-title"><?php echo e(trans('messages.dashboard.notification')); ?></span>
                                </div>
                                <div class="trending-line-chart-wrapper">
                                    <p><?php echo e(trans('messages.dashboard.preview')); ?>:</p>
                                    <span style="font-size:<?php echo e($setting->size); ?>px;color:<?php echo e($setting->color); ?>">
                                        <marquee><?php echo e($setting->notification); ?></marquee>
                                    </span>
                                    <p></p>
                                    <form id="noti" action="<?php echo e(route('dashboard_store')); ?>" method="post">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="row">
                                            <div class="input-field col s12 m8">
                                                <label for="notification"><?php echo e(trans('messages.dashboard.notification_text')); ?></label>
                                                <input id="notification" name="notification" type="text" placeholder="<?php echo e(trans('messages.dashboard.notification_placeholder')); ?>" data-error=".errorNotification" value="<?php echo e($setting->notification); ?>">
                                                <div class="errorNotification"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <label for="size"><?php echo e(trans('messages.font_size')); ?></label>
                                                <input id="size" name="size" type="number" placeholder="Size" max="60" min="15" size="2" data-error=".errorSize" value="<?php echo e($setting->size); ?>">
                                                <div class="errorSize"></div>
                                            </div>
                                            <div class="input-field col s12 m2">
                                                <label for="color"><?php echo e(trans('messages.color')); ?></label>
                                                <input id="color" type="text" placeholder="Color" name="color" data-error=".errorColor" value="<?php echo e($setting->color); ?>">
                                                <div class="errorColor"></div>
                                            </div>
                                            <div class="input-field col s12 m1">
                                                <button class="btn waves-effect waves-light right submit" type="submit" style="padding:0 1.3rem"><?php echo e(trans('messages.go')); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php endif; ?>
		</div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/js/voice.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/materialize-colorpicker.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/chartjs/chart.min.js')); ?>"></script>
    
    <script>
        function nextPatient(){
            var bleep = new Audio();
            bleep.src = '<?php echo e(url('assets/sound/sound1.mp3')); ?>';
            bleep.play();
            window.setTimeout(function() {
         responsiveVoice.speak('Send Next Patient on counter number 2','UK English Female',{rate: 0.85});
        }, 1000); 
        }

        $(function() {
            $('#color').colorpicker();
        });

        <?php if (app('Illuminate\Contracts\Auth\Access\Gate')->check('access', \App\Models\User::class)): ?>
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
                    labels: [<?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $counter): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php if($indx==0): ?> <?php echo "'$counter->name'"; ?>
                            <?php else: ?> <?php echo ", '$counter->name'"; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>],
                    datasets: [
                      {
                          label: "Today",
                          fillColor: "rgba(0,176,159,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(0,176,159,0.9)",
                          highlightStroke: "rgba(220,220,220,9)",
                          data: [<?php $__currentLoopData = $today_calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $today_call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                  <?php if($indx==0): ?> <?php echo "'$today_call'"; ?>
                                  <?php else: ?> <?php echo ", '$today_call'"; ?>
                                  <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>]
                      },
                      {
                          label: "Yesterday",
                          fillColor: "rgba(151,187,205,0.75)",
                          strokeColor: "rgba(220,220,220,0.75)",
                          highlightFill: "rgba(151,187,205,0.9)",
                          highlightStroke: "rgba(220,220,220,0.9)",
                          data: [<?php $__currentLoopData = $yesterday_calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indx => $yesterday_call): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                  <?php if($indx==0): ?> <?php echo "'$yesterday_call'"; ?>
                                  <?php else: ?> <?php echo ", '$yesterday_call'"; ?>
                                  <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>]
                      }
                    ]
                };

                var queueDetailsChartData = [
                  {
                      value: "<?php echo e($today_queue); ?>",
                      color: "#00c0ef",
                      highlight: "#00c0ef",
                      label: "In Queue"
                  },
                  {
                      value: "<?php echo e($missed); ?>",
                      color: "#00a65a",
                      highlight: "#00a65a",
                      label: "Missed"
                  },
                  {
                      value: "<?php echo e($served); ?>",
                      color: "#f39c12",
                      highlight: "#f39c12",
                      label: "Served"
                  },
                  {
                      value: "<?php echo e($overtime); ?>",
                      color: "#dd4b39",
                      highlight: "#dd4b39",
                      label: "Overtime"
                  }
                ];

                var todayVsYesterdayCart = new Chart($("#today-vs-yesterday-chart").get(0).getContext("2d")).Bar(todayVsYesterdayCartData,{
                    responsive:true
                });

                var queueDetailsChart = new Chart($("#queue-details-chart").get(0).getContext("2d")).Pie(queueDetailsChartData,{
                    responsive:true
                });
            });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>