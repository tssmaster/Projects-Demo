<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projects_id', 'title', 'description', 'status', 'duration', 'deleted'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted', 'created_at', 'updated_at'
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'projects_id');
    }
}
