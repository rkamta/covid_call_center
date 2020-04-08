<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSet extends Model
{
    protected $fillable = [
        'slug', 'items', 'active'
    ];
}
