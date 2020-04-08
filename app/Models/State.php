<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [];

    public function districts() {
        return $this->hasMany('App\Models\District');
    }

    public function profiles() {
        return $this->hasMany('App\Models\Profile');
    }
}
