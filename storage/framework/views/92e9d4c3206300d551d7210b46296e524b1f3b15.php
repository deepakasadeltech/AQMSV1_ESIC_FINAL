<?php $__env->startSection('title', trans('messages.display.display')); ?>

<?php $__env->startSection('content'); ?>
    
	<!-- display start -->
	<div id="callarea">
	<div class="dipbox" id="add_dynamic_slider">

	<div class="slider">
    <ul class="slides">
	<?php
	foreach($data as $d1)
	{
    ?>
	<li>
<?php	
		foreach($d1 as $d2){
	?>
      
	  <div class="boxrow" class="caption right-align">
		<table>
		<caption><h1><?php echo $d2[0]['dep']; ?></h1></caption>
		<thead>
		<tr>
		<th>Department</th>
		<th>Token No</th>
		<th>Sub-Department</th>
		<th>Counter</th>
		<th>Action</th>
		</tr>
		</thead>
		<tbody>

		<?php
		foreach($d2 as $d3) {
		?>
		<tr>
		<td id=""><?php echo $d3['dep']; ?></td>
		<td id=""><?php echo $d3['call_number']; ?></td>
		<td id=""><?php echo $d3['sub_dep']; ?></td>
		<td id=""><?php echo $d3['counter']; ?></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<?php } ?>
		</tbody>
		</table>
		</div>

	  
	
	<?php
	} 
	?>
	</li>
	<?php
	}
	?>
	  </ul>
	<div>
	
	</div>
	</div>
	<!--display end --->
	
	
	
	
    <div class="row" style="margin-bottom:0;font-size:<?php echo e($settings->size); ?>px;color:<?php echo e($settings->color); ?>">
        <marquee><?php echo e($settings->notification); ?></marquee>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/voice.min.js')); ?>"></script>
    <script>
        $(function() {
            $('#main').css({'min-height': $(window).height()-114+'px'});
        });
        $(window).resize(function() {
            $('#main').css({'min-height': $(window).height()-114+'px'});
        });

        (function($){
            $.extend({
                playSound: function(){
                  return $("<embed src='"+arguments[0]+".mp3' hidden='true' autostart='true' loop='false' class='playSound'>" + "<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='"+arguments[0]+".mp3' /><source src='"+arguments[0]+".ogg' /></audio>").appendTo('body');
                }
            });
        })(jQuery);

        function checkcall() {
            $.ajax({
                type: "GET",
                url: "<?php echo e(url('assets/files/display')); ?>",
                cache: false,
                success: function(response) {
                    s = JSON.parse(response);
                    if (curr!=s[0].call_id) {
						
                        /*$("#callarea").fadeOut(function(){
                            $('#num0').html(s[0].number);
                            $("#cou0").html(s[0].counter);
                            $('#num1').html(s[1].number);
                            $("#cou1").html(s[1].counter);
                            $('#num2').html(s[2].number);
                            $("#cou2").html(s[2].counter);
                            $('#num3').html(s[3].number);
                            $("#cou3").html(s[3].counter);
                        });
                        $("#callarea").fadeIn();
						*/
						$('#add_dynamic_slider').html(s[1].html);
						$('.slider').slider({ 
							indicators: false,
							height : 600, // default - height : 400
							interval: 8000 // default - interval: 6000
						});
						if (curr!=0) {							
                            var bleep = new Audio();
                            bleep.src = '<?php echo e(url('assets/sound/sound1.mp3')); ?>';
                            bleep.play();

                            window.setTimeout(function() {
                                msg1 = '<?php echo trans('messages.display.token'); ?> '+s[0].call_number+' <?php echo trans('messages.display.please'); ?> <?php echo trans('messages.display.proceed_to'); ?> '+s[0].counter;
                                responsiveVoice.speak(msg1, "<?php echo e($settings->language->display); ?>", {rate: 0.85});
                            }, 800);
                        }
                        curr = s[0].call_id;
						
                    }
                }
            });
        }

        window.setInterval(function() {			
            checkcall();
			
        }, 2000);

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo e(url('assets/files/display')); ?>",
                cache: false,
                success: function(response) {
                    s = JSON.parse(response);
                    curr = s[0].call_id;
                }
            });
            checkcall();
        });
		
		
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mainappqueue', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>