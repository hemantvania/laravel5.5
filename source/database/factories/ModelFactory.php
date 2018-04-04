<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName." ".$faker->lastName,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'userrole' => 2,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\UserMeta::class, function (Faker\Generator $faker) {

    $user = factory(App\User::class)->create();
    $school = factory(App\School::class)->create();

    return [
        'userId'        => $user->id,
        'phone'         => $faker->phoneNumber,
        'profileimage'  => '',
        'addressline1'  => $faker->streetName,
        'addressline2'  => $faker->streetAddress,
        'city'          => $faker->city,
        'state'         => '',
        'zip'           => $faker->postcode,
        'country'       => '1',
        'ssn'           => $faker->uuid,
        'gender'        => '1',
        'default_school' => $school->id,
        'enable_share_screen' => '1',
    ];
});

$factory->define(App\School::class, function (Faker\Generator $faker) {

    return [
        'schoolName' => $faker->firstName. ' '. str_random(5),
        'email' => $faker->unique()->safeEmail,
        'registrationNo' => strtoupper(str_random(5)). random_int(2,5),
        'WebUrl' => $faker->url,
        'logo' => $faker->imageUrl(110,55),
        'address1' => $faker->streetName,
        'address2' => $faker->streetAddress,
        'city' => $faker->city,
        'zip' =>  $faker->postcode,
        'country' => '1',
        'facebook_url' => 'http:://facebook.com/?uuid='.str_random(5),
        'twitter_url' => 'http:://facebook.com/?uuid='.str_random(5),
        'instagram_url' => 'http:://facebook.com/?uuid='.str_random(5),
        'schoolType' => '1',
    ];
});

$factory->define(App\UsersSchools::class, function (Faker\Generator $faker) {

    $user = factory(App\User::class)->create();
    $school = factory(App\School::class)->create();

    return [
        'user_id' => $user->id,
        'school_id' => $school->id,
    ];
});

$factory->define(App\Thread::class, function (Faker\Generator $faker) {

    return [
        'owner' => factory(App\User::class)->create()->id,
    ];
});

$factory->define(App\Classes::class, function (Faker\Generator $faker) {

     return [
        'className' => $faker->sentence,
        'schoolId' => factory(App\School::class)->create()->id,
        'educationTypeId' => 3,
        'standard' => 'Test Standeared',
        'class_duration' => random_int(10,60),
        'class_size' => random_int(2,2),
    ];
});

$factory->define(App\Material::class, function (Faker\Generator $faker) {

    return [
        'categoryId' => 1,
        'materialName' => $faker->sentence(),
        'description' => $faker->paragraph(10),
        'link' => 'https://www.youtube.com/watch?v=avZTQgLs064  ',
        'materialType' => 'Video',
        'uploadBy' => factory(App\User::class)->create()->id,
        'materialIcon'=> '',
        'isDownloadable'=> '',
    ];
});