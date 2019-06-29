<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Department;
use App\Models\ParentDepartment;
use App\Models\Counter;

class UserRepository
{
    public function getAll()
    {
        return User::all();
    }

    public function getUserDoctorName()
    {
     return User::with('department', 'counter') 
                   ->where('role', 'D')
                   ->get();
    }
    
    public function getAllUserName()
    { return User::with('department', 'counter') 
                   ->where('role', 'S')
                   ->get();
    }

    public function getAdminDetails()
    { return User::with('department', 'counter') 
                   ->where('role', 'A')
                   ->get();
    }

    public function getHelpdeskDetails()
    { return User::with('department', 'counter') 
                   ->where('role', 'H')
                   ->get();
    }

    public function getCmoDetails()
    { return User::with('department', 'counter') 
                   ->where('role', 'C')
                   ->get();
    }

    public function getDisplayCtrlDetails()
    { return User::with('department', 'counter') 
                   ->where('role', 'I')
                   ->get();
    }

    public function getPDepartments()
    {
        return ParentDepartment::all();
    }
	
	public function getDepartments()
    {
        return Department::all();
    }

   


}
