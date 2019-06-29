<?php

namespace App\Repositories;

use App\Models\ParentDepartment;

class ParentDepartmentRepository
{
    public function getAll()
    {
        return ParentDepartment::all();
    }

}
