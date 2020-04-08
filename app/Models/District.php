<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name', 'state_id'
    ];

    protected $hidden = [];

    
    public function profiles() {
        return $this->hasMany('App\Models\Profile');
    }

    public function state() {
        return $this->belongsTo('App\Models\State');
    }
}
