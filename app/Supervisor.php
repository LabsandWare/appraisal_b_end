<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'employee_id'
    ];


    public function employees()
    {
        return $this->hasMany('App\Employee');
    }

}