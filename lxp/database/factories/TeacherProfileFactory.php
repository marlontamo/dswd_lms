<?php

use Faker\Generator as Faker;

$factory->define(App\Models\TeacherProfile::class, function (Faker $faker) {
    return [
        'user_id' => 2,
        'facebook_link' => $faker->url,
        'twitter_link' => $faker->url,
        'linkedin_link' => $faker->url,
    ];
});
