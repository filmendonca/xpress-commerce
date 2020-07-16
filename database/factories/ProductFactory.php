<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        "id_categoria" => rand(1, 3),
        "nome" => $faker->name(2),
        "descrição" => $faker->paragraph(2),
        "preço" => $faker->randomFloat(2, 1, 1000),
        "stock" => $faker->randomNumber(2),
        "classificacao" => 0,
        "imagem" => "prod_default.jpg"
    ];
});
