<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;
    protected $table = 'departments';
    protected $fillable = [
        'id', 'department_name', 'active'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function req()
    {
        return $this->hasMany(Req::class);
    }
}
