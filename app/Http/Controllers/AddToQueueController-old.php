<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AddToQueueRepository;
use App\Models\Setting;
use App\Models\Department;
use App\Models\User;
use App\Models\Counter;
use App\Models\ParentDepartment;
use App\Models\UhidMaster;


class AddToQueueController extends Controller
{
    protected $add_to_queues;

    public function __construct(AddToQueueRepository $add_to_queues)
    {
        $this->add_to_queues = $add_to_queues;
    }

    public function index(Request $request)
    {
        $settings = Setting::first();

        \App::setLocale($settings->language->code);
        return view('addtoqueue.index', [
            'settings' => $settings,
            'departments' => $this->add_to_queues->getActiveDepartments(),
            'getpdepartments' => $this->add_to_queues->getPdepartments(),
            'doctorreports' => $this->add_to_queues->doctorreports(),	
            'userdoctordetails' => $this->add_to_queues->getUserDoctorName(),
            'getdepartmentbydoctors' => $this->add_to_queues->getDepartmentByDoctor(),			
        ]);

       // print_r($pdepartments);
    }

    public function refreshToken()
    {
        $departments = $this->add_to_queues->getActiveDepartments();
        $html = '';
        foreach($departments as $department){
            if( $department->is_uhid_required == 1){
                $html .='<a style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="waves-effect waves-light btn modal-trigger" href="#modal2_'.$department->id.'">'.$department->name.'<sup style="color:#890202; font-size:15px">*</sup></a>';
            }else{
                $html .='<button style="margin-bottom:10px;margin-right:5px;text-transform:uppercase" class="btn waves-effect waves-light csfloat" onclick="queue_dept('.$department->id.')" style="text-transform:none">'.$department->name.'</button>';
            }
        }

        return $html;
    }

    public function postDept(Request $request)
    {
		$department = Department::findOrFail($request->department);
		$request->session()->flash('printFlag', true);
		$is_uhid_required = $this->isUhidRequired($department->id);
		//var_dump($is_uhid_required);die;
		if($is_uhid_required){
			$uhid = $request->uhid;
			$is_uhid_exist = $this->isUHIDExist($uhid);
			if(!$is_uhid_exist) {
				$request->session()->flash('printFlag', false);
				flash()->warning('Invalid UHID');
				return redirect()->route('add_to_queue');
			}
		}
        

        $last_token = $this->add_to_queues->getLastToken($department);

        if($last_token) {
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => ((int)$last_token->number)+1,
                'called' => 0,
				'uhid' => $request->uhid,
                'priority' => $request->priority,
            ]);
        } else {
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => $department->start,
                'called' => 0,
				'uhid' => $request->uhid,
                'priority' => $request->priority,
            ]);
        }

        $total = $this->add_to_queues->getCustomersWaiting($department);

        event(new \App\Events\TokenIssued());

        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('number', ($department->letter!='')?$department->letter.''.$queue->number:$queue->number);
        $request->session()->flash('total', $total);
		$request->session()->flash('uhid', $request->uhid);
        $request->session()->flash('priority', $request->priority);

        flash()->success('Token Added');
        return redirect()->route('add_to_queue');
    }
	
	private function isUhidRequired($department_id)
	{
		$flag = false;
		$result = Department::find($department_id);
		if(!empty($result)){
			$flag = ($result->is_uhid_required == 1) ? true : false;
		}
		return $flag;
	}
	
	private function isUHIDExist($uhid)
	{
		$flag = false;
		$result = UhidMaster::where('uhid', $uhid)->count();
		$flag = ($result > 0) ? true : false;
		return $flag;
	}
}
