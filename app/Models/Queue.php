<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = ['pid', 'department_id', 'number','regnumber', 'called', 'uhid', 'priority'];

    public function call()
	{
		return $this->hasOne('App\Models\Call');
	}

    public function department()
	{
		return $this->belongsTo('App\Models\Department');
	}
	public function counter()
	{
		return $this->belongsTo('App\Models\Counter');
	}
   
	public function doctorreport()
	{
		return $this->belongsTo('App\Models\DoctorReport');
	}

	public function getDoctorName()
	{
		return $this->belongsTo('App\Models\User');
	}

}
