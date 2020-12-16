<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Message::truncate();
        factory(App\Message::class, 50)->create();
    }
}
