<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSet extends Model
{
    protected $fillable = [
        'uuid', 'items', 'user_id', 'active'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
