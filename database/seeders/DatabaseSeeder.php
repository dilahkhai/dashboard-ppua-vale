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

        // DB::table("areas")->insert([
        //     ["area"  => "Furnace-Converter"],
        //     ["area"  => "Process Plant Automation"],
        //     ["area"  => "Infrastructure"],
        //     ["area"  => "Utulities"],
        // ]);
        
        // dd(DB::table('areas')->get()); // Tambahkan ini untuk debug
        
        // $this->call(UserSeeder::class);
        

        // DB::table("departments")->insert([
        //     [
        //         "name"  => "RND"
        //     ],
        //     [
        //         "name"  => "Automation project"
        //     ],
        //     [
        //         "name"  => "Tech. Support"
        //     ],
        //     [
        //         "name"  => "Management"
        //     ],
        //     [
        //         "name"  => "Maintenance"
        //     ],
        // ]);

        $this->call(TasksTableSeeder::class);
        $this->call(LinksTableSeeder::class);

        

    }
}
