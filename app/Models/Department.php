<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'regcode', 'letter', 'start', 'pid', 'is_uhid_required'];

    public function queues()
	{
		return $this->hasMany('App\Models\Queue');
	}

    public function calls()
	{
		return $this->hasMany('App\Models\Call');
	}
}
