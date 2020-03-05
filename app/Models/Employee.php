<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'unique_id', 'supervisor_id'
    ];


    public function supervisor()
    {
        return $this->belongsTo('App\Supervisor');
    }

}
