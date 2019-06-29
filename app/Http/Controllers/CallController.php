<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CallRepository;
use App\Models\User;
use App\Models\ParentDepartment;
use App\Models\Department;
use App\Models\Counter;
use App\Models\Call;
use App\Models\UhidMaster;
use Carbon\Carbon;
use App\Models\Setting;
class CallController extends Controller
{
    protected $calls;

    public function __construct(CallRepository $calls)
    {
        $this->calls = $calls;
    }

    public function index(Request $request)
    {
		$this->authorize('access', Call::class);
        event(new \App\Events\TokenIssued());

        return view('user.calls.index', [
            'users' => $this->calls->getUsers(),
            'counters' => $this->calls->getCounters(),
			'pdepartments' => $this->calls->getPDepartments(),
            'departments' => $this->calls->getActiveDepartments(),
        ]);
    }

    public function newCall(Request $request)
    {
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

        $queue = $this->calls->getNextToken($department);

        if($queue==null) {
            flash()->warning('No Token for this department');
            return redirect()->route('calls');
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

        $request->session()->flash('department', $department->id);
        $request->session()->flash('counter', $counter->id);

        event(new \App\Events\TokenIssued());
        event(new \App\Events\TokenCalled());

        flash()->success('Token Called');
        return redirect()->route('calls');
    }

    public function postDept(Request $request, Department $department)
    {
		$request->session()->flash('printFlag', true);
		$is_uhid_required = $this->isUhidRequired($department->id);
		if($is_uhid_required){
			$uhid = 123;
			//$uhid = $request->uhid;
			$is_uhid_exist = $this->isUHIDExist($uhid);
			if(!$is_uhid_exist) {
				$request->session()->flash('printFlag', false);
				flash()->warning('Invalid UHID');
				return redirect()->route('calls');
			}
        }
        
		//------------
        $todaydate = date('m').substr(date('Y'),2);
        $dublicate = $department->regcode.$todaydate.$request->registration;
        $get_Registration = $this->calls->getRegistNumber($dublicate);
         
        $reqregistration = $request->registration;
	//------------------------------------	
	if($reqregistration == ''){
		$request->session()->flash('printFlag', false);
		flash()->warning('Please Enter 5 digits Only Number');
		return redirect()->route('calls');	
	}
	//-------------------------------------
		$pattern = '~^[0-9]{5}+$~';
		if(!preg_match($pattern, $reqregistration)){
		   $request->session()->flash('printFlag', false);
		   flash()->warning('Sorry !!! Your Input is not Matching, Enter Only Number 5 digits');
		   return redirect()->route('calls');	 
		}else{
			echo 'yes';
		}
    //---------------------------------------

        if($get_Registration > 0){
            $request->session()->flash('printFlag', false);
            flash()->warning('This Registration Number All Ready Exist');
            return redirect()->route('calls');
        }
      //--------------
        $last_token = $this->calls->getLastToken($department);
        //echo '<pre>'; print_r($last_token->toArray());  die;
        if($last_token) {
			$tokenNumber = ((int)$last_token->number)+1;
			$istkenExist = $this->calls->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				flash()->warning('Token already issued');
				return redirect()->route('calls');
            }
            
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => ((int)$last_token->number)+1,
                'regnumber' => $department->regcode.$todaydate.$request->registration,
                'called' => 0,
                'uhid' => 123,
				//'uhid' => $request->uhid,
                'priority' => $request->priority,
            ]);
        } else {
			$tokenNumber = $department->start;
			$istkenExist = $this->calls->isTokenExist($department->pid, $department->id, $tokenNumber);
			if($istkenExist > 0){
				flash()->warning('Token already issued');
				return redirect()->route('calls');
			}
            $queue = $department->queues()->create([
				'pid' => $department->pid,
                'number' => $department->start,
                'regnumber' => $department->regcode.$todaydate.$request->registration,
                'called' => 0,
                'uhid' => 123,
				//'uhid' => $request->uhid,
                'priority' => $request->priority,
            ]);
        }

        $total = $this->calls->getCustomersWaiting($department);

        event(new \App\Events\TokenIssued());
        $staffuser = User::find(Auth::user()->id);
        $stt = Setting::first();
        $request->session()->flash('registration_no',  $department->regcode.$todaydate.$request->registration);
        $request->session()->flash('department_name', $department->name);
        $request->session()->flash('number', ($department->letter!='')?$department->letter.'-'.$queue->number:$queue->number);
        $request->session()->flash('total', $total);
		$request->session()->flash('uhid', $request->uhid);
        $request->session()->flash('priority', $request->priority);
        $request->session()->flash('company_name', $stt->name);
        $request->session()->flash('staffname', $staffuser->name);


        flash()->success('Token Added');
        return redirect()->route('calls');
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
    
    public function getRegistration(Request $request)
    { 
        //$regist = $request->regist;
		$regist = $request->registration;
		$result = Queue::first();
		$regResult = substr($result->regnumber, 6);
		
			if($regResult !== $regist){
				$output = '<span class="plbox">Valid</span>';
			}else{
                $output = 'Invalid';
            }
		
        return $output;
    }
	
	
    public function recall(Request $request)
    {
        $call = Call::find($request->call_id);
        $new_call = $call->replicate();
        $new_call->save();

        $call->delete();

        event(new \App\Events\TokenCalled());

        flash()->success('Token Called');
        return $new_call->toJson();
    }
	
	public function postPdept(Request $request)
    { 
		$department = Department::where('pid', $request->pid)->get();
        return $department->toJson();
    }
}
