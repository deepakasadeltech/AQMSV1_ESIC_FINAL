<?php

namespace App\Listeners;

use App\Events\CsvGenerate;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Call;
use App\Models\ParentDepartment;
use App\Models\DoctorReport;
use App\Models\User;
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
        
		$calls = Call::all()
                   ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))->where('view_status', 1);
                    
        $headers = array( "" );
		$fp = fopen('D:\Axamp\htdocs\aqmsv1\assets\files\doctor_list.txt', 'wb');
		//fputcsv($fp, $headers);
		$counter = 1; $break = '\n';
		foreach($calls as $cls){
            $user = User::with('counter')->find($cls->user_id);
            $department = Department::find($cls->department_id);
           if($cls->view_status==1){
			   $txt = $counter. " " . $user->counter->id.$cls->number . "\r\n";
			   fwrite($fp, $txt);
            //$row = [ ','];
			}
            else{
				$txt = $counter. " 0 \r\n";
				fwrite($myfile, $txt);
				//$row = ["0000"];	
			}
           // $d = str_replace(",", "|", $row);
            //fputcsv($fp, $row);
            
			$counter++;
			
		}
        fclose($fp);
    }

	
}
