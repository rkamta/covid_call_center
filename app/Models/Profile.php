<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    
    protected $fillable = [
        'avatar', 'state_id', 'disctrict_id'
    ];

    protected $hidden = [];

    public function state() {
        return $this->belongsTo('App\Models\State');
    }

    public function district() {
        return $this->belongsTo('App\Models\District');
    }
}
