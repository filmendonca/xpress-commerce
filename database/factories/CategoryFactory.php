<?php

use App\Category;
use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        "nome" => $faker->name(1)
    ];
});
