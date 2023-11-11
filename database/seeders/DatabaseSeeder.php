<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table("areas")->insert([
            [
                "area"  => "Furnace-Converter"
            ],
            [
                "area"  => "Dryer-Kiln"
            ],
            [
                "area"  => "Infrastructure"
            ],
            [
                "area"  => "Utulities"
            ],
        ]);

        DB::table("departments")->insert([
            [
                "name"  => "RND"
            ],
            [
                "name"  => "Automation project"
            ],
            [
                "name"  => "Tech. Support"
            ],
            [
                "name"  => "Management"
            ],
            [
                "name"  => "Maintenance"
            ],
        ]);

        $this->call(UserSeeder::class);

    }
}
