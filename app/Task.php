<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends Model
{
    use SoftDeletes;
    protected $table = 'tasks';
    public $primaryKey = 'task_id';
    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_name','task_date', 'status'
    ];

    public function getTaskNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setTaskNameAttribute($value)
    {
        return $this->attributes['task_name'] = $value;
    }


    public function getTaskDateAttribute($value)
    {
        return $value;
    }

    public function setTaskDateAttribute($value)
    {
        return $this->attributes['task_date'] = ucwords($value);
    }

    public function getStatusAttribute($value)
    {
        return ucwords($value);
    }

    public function setStatusAttribute($value)
    {
        return $this->attributes['status'] = $value;
    }


    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getDeletedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }
}
