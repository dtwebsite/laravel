<?php

use Illuminate\Database\Seeder;
// use Illuminate\Database\Eloquent\Mobel;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create();
    }
}
