<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pet;
use App\Models\PetOwner;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Pet::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'photo' => $faker->image('public/uploads', 400, 300, null, false),
        'age' => 19,
        'informations' => 'Super dócil, atende pelo nome de jes',
        'city' => 'Marília',
        'state' => 'SP',
        'status' => 'lost',
        'pet_owners_id' => factory(App\Models\PetOwner::class)
    ];
});
