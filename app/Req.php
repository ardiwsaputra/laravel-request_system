<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    //public $timestamps = false;
    protected $table = 'requests';
    protected $fillable = [
        'request_no', 'name', 'email', 'subject', 'description', 'feedback', 'file', 'created_at', 'updated_at', 'status', 'department_id', 'service_id', 'user_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->format('d-m-Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])
            ->diffForHumans();
    }
}
