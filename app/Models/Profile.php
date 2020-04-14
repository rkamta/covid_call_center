<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    
    protected $fillable = [
        'user_id', 'avatar', 'state_id', 'district_id'
    ];

    protected $hidden = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function state() {
        return $this->belongsTo('App\Models\State');
    }

    public function district() {
        return $this->belongsTo('App\Models\District');
    }
}
