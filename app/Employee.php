<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'unique_id'
    ];


    public function supervisor()
    {
        return $this->belongsTo('App\Supervisor');
    }

}
