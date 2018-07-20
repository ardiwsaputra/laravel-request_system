<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;
    protected $table = 'services';
    protected $fillable = [
        'id', 'service_name', 'active', 'department_id'
    ];

    public function req()
    {
        return $this->hasMany(Req::class);
    }
}
