<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        //or create the factory call in a separate seeder class and use SeederClass::call to make the call here..
        \App\Models\Intern::factory(20)->create();
    }
}
