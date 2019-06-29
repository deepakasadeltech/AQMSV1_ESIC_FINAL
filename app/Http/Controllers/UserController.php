<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Models\User;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Counter;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function index(Request $request)
    {  
        $this->authorize('access', User::class);

        return view('user.users.index', [
            'users' => $this->users->getAll(),
            'userdoctordetails' => $this->users->getUserDoctorName(),
            'getalluserdetails' => $this->users->getAllUserName(),
            'getadmindetails' => $this->users->getAdminDetails(),
            'gethepdeskdetails' => $this->users->getHelpdeskDetails(),
            'getcmodetails' => $this->users->getCmoDetails(),
            'getdisplayctrldetails' => $this->users->getDisplayCtrlDetails(),

            'pdepartments' => $this->users->getPDepartments(),
            'departments' => $this->users->getDepartments(),				
        ]);
    }

    public function create(Request $request)
    {  
         $this->authorize('access', User::class);

        return view('user.users.create',[
            'pdepartments' => $this->users->getPDepartments(),
            'departments' => $this->users->getDepartments(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('access', User::class);

        $this->validate($request, [
            'name' => 'bail|required',
            'username' => 'bail|required|min:6|unique:users,username',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|min:6|confirmed',
            'user_status' => 'bail|required',
        ]);

        $data = $request->all();
       // echo "<pre>"; print_r($data);die;
       if($data['role'] != 'D') {
        $data['pid'] = NULL;
        $data['department_id'] = NULL;
       }
        
       // echo "<pre>"; print_r($data);die;
        //$data['role'] = 'S';
        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        flash()->success('User created');
        return redirect()->route('users.index');
    }

    public function getPassword(Request $request, User $user)
    {
        $this->authorize('access', User::class);

        if($user->id==$request->user()->id) abort(404);

        return view('user.users.password', [
            'cuser' => $user,
        ]);
    }

    public function postPassword(Request $request, User $user)
    {
        $this->authorize('access', User::class);

        if($user->id==$request->user()->id) abort(404);

        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $user->password = bcrypt($request->password);
        $user->save();

        flash()->success('User Data Updated');
        return redirect()->route('users.index');
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorize('access', User::class);

        $user->delete();

        flash()->success('User deleted');
        return redirect()->route('users.index');
    }

    public function postUpDept(Request $request)
    { 
		$department = Department::where('pid', $request->pid)->get();
        return $department->toJson();
    }

    public function updateStatus($id)
    {
        $users = User::find($id);
        if($users->user_status == 1) {
            $users->user_status = 2;
            $msg = "User Inactive";
        }else{
            $users->user_status = 1;
            $msg = "User Active";
        }

        $users->save();
        flash()->success($msg);
        return redirect()->route('users.index');

    }

}
