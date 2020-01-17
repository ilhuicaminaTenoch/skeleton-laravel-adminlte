<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Roles;
use Faker\Generator as Faker;

$factory->define(Roles::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'descripcion' => $faker->text(50),
        'activo' => 1
    ];
});
