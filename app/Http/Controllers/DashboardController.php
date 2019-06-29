<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\DashbordRepository;
use App\Models\Call;
use App\Models\User;
use App\Models\Counter;
use App\Models\Queue;
use Carbon\Carbon;
use App\Models\DoctorReport;
use App\Models\PatientCall;
use App\Models\Department;
use App\Models\ParentDepartment;




class DashboardController extends Controller
{
   protected $setting;

    public function __construct(DashbordRepository $setting)
    {
        $this->setting = $setting;
    }

    public function index()
    {
		return view('user.dashboard.index', [
            'setting' => $this->setting->getSetting(),
            'today_queue' => $this->setting->getTodayQueue(),
            'missed' => $this->setting->getTodayMissed(),
            'overtime' => $this->setting->getTodayOverTime(),
            'served' => $this->setting->getTodayServed(),
            'counters' => $this->setting->getCounters(),
            'today_calls' => $this->setting->getTodayCalls(),
            'yesterday_calls' => $this->setting->getYesterdayCalls(),
			'patient_list' =>$this->setting->getPatientList(Auth::user()->pid, Auth::user()->department_id),
			'patient_list_doctorwise' =>$this->setting->getPatientListDoctorWise(Auth::user()->id, Auth::user()->department_id),
			'patient_seen' =>$this->setting->getPatientSeenList(Auth::user()->id),
			'role'=> Auth::user()->role,
			'pdepartments' => $this->setting->getPDepartmentName(Auth::user()->pid),
			'departments' => $this->setting->getDepartments(),
			'daily_avgtime_of_doctor' =>$this->setting->getDailyDoctorAvgTime(Auth::user()->id),
			'today_queue_bycounter' => $this->setting->getTodayQueueByCounter(Auth::user()->department_id),
			'today_called_bycounter' => $this->setting->getTodayPatientCalledByCounter(Auth::user()->department_id),
			'user_details' => $this->setting->getUserDetails(Auth::user()->pid, Auth::user()->department_id, Auth::user()->counter_id),
			'patient_called_bydoctor' =>$this->setting->getTodayPatientCalledByDoctor(Auth::user()->id),

			'users' => $this->setting->getUserDoctor(),
			'staffusers' => $this->setting->getUserStaff(),
			'pardepartments' => $this->setting->getPDepartments(),

			'totaldoctor_absent' => $this->setting->gettotalDoctorAbsent(),
			'totaldoctor_present' => $this->setting->gettotalDoctorPresent(),

			'get_all_department_total_queue_in_today' => $this->setting->getAllDepartmentTotalQueueInToday(),
			'get_all_department_total_called_in_today' => $this->setting->getAllDepartmentTotalCalledInToday(),
			'get_all_department_total_called_but_not_seen_today' => $this->setting->getAllDepartmentTotalCalledbutNotSeenToday(),
			'get_all_department_total_pending_for_call' => $this->setting->getAllDepartmentTotalpendingTokenForCallToday(),
			'get_all_department_doctor_Start_but_notSeen' => $this->setting->getAllDepartmentStartWorkbutNotEndToday(),

			'getTodayAvgConsultingTime' => $this->setting->getTodayAvgConsultingTime(),
			'getTodayAvgWaitingTime' => $this->setting->getTodayAvgWaitingTime(),
			'getTodaytpatienttoDoctor' => $this->setting->getTodaytpatienttoDoctor(),

		


		]);
  
		
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'notification' => 'bail|required|min:5',
            'size' => 'bail|required|numeric',
            'color' => 'required',
        ]);

        $setting = $this->setting->updateNotification($request->all());

        flash()->success('Notification updated');
        return redirect()->route('dashboard');
    }
	
	public function startCounter($id = '')
	{
		$pid = Auth::user()->pid;
		$department_id = Auth::user()->department_id;
		
		$isCallValid = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('id', $id)
		->where('pid', $pid)
		->where('department_id', $department_id)
		->count();
		if($isCallValid == 0){
			flash()->warning('Invalid  request');
			return redirect()->route('dashboard');
		}
		
		$calls = Call::find($id);
		$calls->view_status = 2;
		$calls->doctor_work_start = 1;
		$calls->doctor_work_start_date = date('Y-m-d H:i:s');
		$calls->save();
		
		//event(new \App\Events\CsvGenerate());
		//insert/update
		flash()->success('Token Time Start');
		return redirect()->route('dashboard');
		
	}
	
	public function endCounter($id = '')
	{
		$pid = Auth::user()->pid;
		$department_id = Auth::user()->department_id;
		
		$isCallValid = Call::with('department', 'counter')
		->whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('id', $id)
		->where('pid', $pid)
		->where('department_id', $department_id)
		->count();
		
		if($isCallValid == 0){
			flash()->warning('Invalid  request');
			return redirect()->route('dashboard');
		}
		
		$calls = Call::find($id);
		$queue_id = $calls->queue_id;
		$start_time = $calls->doctor_work_start_date;
		$number = $calls->number;
		$end_time = date('Y-m-d H:i:s');
		$calls->doctor_work_end = 1;
		$calls->view_status = 3;
		$calls->doctor_work_end_date = $end_time;
		$calls->view_status = 0;
		$calls->save();
		$queue = Queue::find($queue_id);
		$queue->queue_status = 0;
		$queue->save();
		
		
		//departments
		$departments = Department::find($department_id);
		//insert in reports
		$reports = new DoctorReport();
		$reports->call_id = $id;
		$reports->department_id = $department_id;
		$reports->user_id = Auth::user()->id;
		$reports->pid = $pid;
		$reports->token_number = $departments->letter.''.$number;
		$reports->start_time = $start_time;
		$reports->end_time = $end_time;
		$reports->save();
	//--------------------------------------
	    event(new \App\Events\CsvGenerate());	
		event(new \App\Events\TokenCalled());
		event(new \App\Events\TokenIssued());
		flash()->success('Token Closed');
		return redirect()->route('dashboard');
		
	}

	public function doctorDirectCall(Request $request)
    { 
		for($i=0; $i <= 4; $i++){
        $this->validate($request, [
            'user' => 'bail|required|exists:users,id',
            'counter' => 'bail|required|exists:counters,id',
            'pid' => 'bail|required|exists:parent_departments,id',
			'department' => 'bail|required|exists:departments,id',
		]);
		
		$user = User::findOrFail($request->user);
        $counter = Counter::findOrFail($request->counter);
        $pdepartment = ParentDepartment::findOrFail($request->pid);
		$department = Department::findOrFail($request->department);

		

		$queue = $this->setting->getNextToken($department);
		
		if($queue==null) {
            flash()->warning('No Token for this department');
            return redirect()->route('dashboard');
		}
		
		$call = $queue->call()->create([
            'pid' => $pdepartment->id,
			'department_id' => $department->id,
            'counter_id' => $counter->id,
            'user_id' => $user->id,
            'number' => $queue->number,
            'called_date' => Carbon::now()->format('Y-m-d'),
		]);
		
		$queue->called = 1;
		$queue->save();
		}
        $request->session()->flash('pdepartment', $pdepartment->id);
        $request->session()->flash('department', $department->id);
        $request->session()->flash('counter', $counter->id);

        //event(new \App\Events\TokenIssued());
        event(new \App\Events\TokenCalled());

        flash()->success('Token Called');
        return redirect()->route('dashboard');
	}	
	


	public function PatientStatus($id='')
	{   

		$alreadyActivated = Call::whereBetween('created_at', [Carbon::now()->format('Y-m-d').' 00:00:00', Carbon::now()->format('Y-m-d').' 23:59:59'])
		->where('user_id', Auth::user()->id)
		->where('view_status', 1)
		->where('id', '!=',$id)
		->count();
		if($alreadyActivated > 0){
			flash()->warning("You have already called a patient");
			return redirect()->route('dashboard');
		}
		
		$calls = Call::find($id);
		
		if($calls->view_status == 0) {
			$calls->view_status = 1;
			$calls->doctor_work_start = 1;
		   $calls->doctor_work_start_date = date('Y-m-d H:i:s');
            $msg = "Token No. Display ON";
        }else{
			$calls->view_status = 0;
			$calls->doctor_work_start = 0;
		    $calls->doctor_work_start_date = date('Y-m-d H:i:s');
            $msg = "Token No. Display OFF";
        }


		//$calls->view_status = 1;
	
		$calls->save();
		
	//--------------------------------------
	    event(new \App\Events\CsvGenerate());	
		flash()->success($msg);
		return redirect()->route('dashboard');



    }

	


}
