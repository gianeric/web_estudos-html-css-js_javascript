<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Communique extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'pets_id',
    ];
}
