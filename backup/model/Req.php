<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    public $timestamps = false;
    protected $table = 'requests';
    protected $fillable = [
        'request_no', 'name', 'email', 'subject', 'description', 'file', 'status', 'department_id', 'service_id', 'user_id'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
