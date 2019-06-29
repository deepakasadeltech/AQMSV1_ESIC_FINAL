<?php

namespace App\Repositories;
use App\Models\User;
use App\Models\Department;
use App\Models\Counter;
use App\Models\ParentDepartment;
use App\Models\DoctorReport;
use Carbon\Carbon;

class AddToQueueRepository
{
    public function getDepartments()
    {
        return Department::all();
    }

    public function getActiveDepartments()
    {
        $depid = User::all()->where('user_status', '1');
       
        $ids = [];
        foreach($depid as $id){
            if(!empty($id->department_id)){
                $ids[$id->department_id] = $id->department_id;
            }
        }
        return Department::whereIn('id', $ids)->get();
    }
    
	public function getPdepartments()
    {
        return ParentDepartment::all();
    }

    public function doctorreports()
    {
        return DoctorReport::all();
    }

    public function getDepartmentByDoctor()
    {
        return User::with('department', 'counter') 
                   ->where('role', 'D')
                   ->where('user_status', '1')
                   ->get();
    }

    public function getUserDoctorName()
    {
        return User::with('department', 'counter') 
                   ->where('role', 'D')
                   ->get();
    }

    public function getLastToken(Department $department)
    {
        return $department->queues()
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->orderBy('created_at', 'desc')
                    ->first();
    }

    public function getCustomersWaiting(Department $department)
    {
        return $department->queues()
                    ->where('called', 0)
                    ->where('created_at', '>', Carbon::now()->format('Y-m-d 00:00:00'))
                    ->count();
    }
}
