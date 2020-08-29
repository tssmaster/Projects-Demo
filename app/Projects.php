<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status', 'duration', 'client', 'company', 'deleted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted', 'created_at', 'updated_at'
    ];
    
    public function tasks()
    {
        return $this->hasMany(Tasks::class)->orderBy('created_at', 'DESC');
    }
}
