<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    /**
     * Quantity per page for paginate
     *
     * @var array
     */
    protected $perPage = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'photo', 'age', 'informations', 'city', 'state', 'status', 'pet_owners_id'
    ];

    /**
     * Get the pet that owns the owner.
     */
    public function owner() {
        return $this->belongsTo(PetOwner::class, 'pet_owners_id');
    }

    public function communiques() {
        return $this->hasMany(Communique::class, 'pets_id');
    }
}
