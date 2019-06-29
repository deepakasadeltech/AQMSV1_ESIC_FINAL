<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ParentDepartmentRepository;
use App\Models\ParentDepartment;

class ParentDepartmentController extends Controller
{
    protected $pdepartments;

    public function __construct(ParentDepartmentRepository $pdepartments)
    {
        $this->pdepartments = $pdepartments;
    }

    public function index()
    {
        $this->authorize('access', ParentDepartment::class);

        return view('user.parent_departments.index', [
            'parent_departments' =>$this->pdepartments->getAll(),
        ]);
    }

    public function create()
    {
        $this->authorize('access', ParentDepartment::class);

        return view('user.parent_departments.create');
    }

    public function store(Request $request)
    {
        $this->authorize('access', ParentDepartment::class);

        $this->validate($request, [
            'name' => 'required'
        ]);

        ParentDepartment::create($request->all());

        flash()->success('Parent Department created');
        return redirect()->route('parent_departments.index');
    }

    public function edit($id)
    {
        $this->authorize('access', ParentDepartment::class);
        return view('user.parent_departments.edit', [
            'department' =>  ParentDepartment::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('access', ParentDepartment::class);

        $this->validate($request, [
            'name' => 'required'            
        ]);
		$parent_departments = ParentDepartment::find($id);
        $parent_departments->name = $request->name;
        $parent_departments->save();
		flash()->success('Parent Department updated');
        return redirect()->route('parent_departments.index');
    }

    public function destroy($id)
    {
        $this->authorize('access', ParentDepartment::class);
		$pepartment = ParentDepartment::find($id);
        $pepartment->delete();
        flash()->success('Parent Department deleted');
        return redirect()->route('parent_departments.index');
    }
}
