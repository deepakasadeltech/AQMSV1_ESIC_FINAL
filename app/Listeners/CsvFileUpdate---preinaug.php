<?php

namespace App\Listeners;

use App\Events\CsvGenerate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Call;
use App\Models\ParentDepartment;
use App\Models\DoctorReport;
use App\Models\User;
use App\Models\Counter;
use App\Models\Department;
use Carbon\Carbon;

class CsvFileUpdate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(CsvGenerate $event)
    {
        
        $calls = Call::with('counter')
                   //->orderBy('counter_id', 'ASC')
                   ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))->where('view_status', 1)->get();
                    
       $headers = array( "" );
       // $headers = array( "Room NO.", "Room ID", "Token No." );
        $fp = fopen('C:\Token Display\token.txt', 'wb');
        //fopen($fp, $headers);
        $counter = 1; $break = '\n';
		foreach($calls as $cls){
            $user = User::with('counter')->find($cls->user_id);
            $department = Department::find($cls->department_id);
           if($cls->view_status==1){
               //$txt = $counter. " " . $user->counter->id.$cls->number . "\r\n";
               $txt = $cls->number . "\r\n";
              // $txt = $user->counter->display_sequence.' '.$user->counter->name.' '.$cls->number . "\r\n";
              // $txt = $user->counter->name." ".$user->counter->id." ".$cls->number . "\r\n";
			   fwrite($fp, $txt);
			}
            else{
				$txt = $counter. " 0 \r\n";
				fwrite($myfile, $txt);
			}
         
            
			$counter++;
			
        }
        
        fclose($fp);
    }

	
}
