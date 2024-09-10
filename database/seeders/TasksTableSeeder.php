<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = DB::table('users')->first()->id;

        DB::table('tasks')->insert([
            ['id'=>1, 'name'=>'Project #1', 'user_id'=>1, 'start_date'=>'2024-8-01 00:00:00', 
                'end_date'=>'2024-8-05 00:00:00', 'progress'=>0.8, 'parent'=>0],
            ['id'=>2, 'name'=>'Task #1', 'user_id'=>2, 'start_date'=>'2024-8-06 00:00:00', 
                'end_date'=>'2024-8-08 00:00:00', 'progress'=>0.5, 'parent'=>1],
            ['id'=>3, 'name'=>'Task #2', 'user_id'=>3, 'start_date'=>'2024-8-05 00:00:00', 
                'end_date'=>'2024-8-10 00:00:00', 'progress'=>0.7, 'parent'=>1],
            ['id'=>4, 'name'=>'Task #3', 'user_id'=>4, 'start_date'=>'2024-8-07 00:00:00', 
                'end_date'=>'2024-8-09 00:00:00', 'progress'=>0, 'parent'=>1],
            ['id'=>5, 'name'=>'Task #1.1', 'user_id'=>5, 'start_date'=>'2024-8-05 00:00:00', 
                'end_date'=>'2024-8-09 00:00:00', 'progress'=>0.34, 'parent'=>2],
            ['id'=>6, 'name'=>'Task #1.2', 'user_id'=>16, 'start_date'=>'2024-8-11 00:00:00', 
                'end_date'=>'2024-8-15 00:00:00', 'progress'=>0.5, 'parent'=>2],
            ['id'=>7, 'name'=>'Task #2.1', 'user_id'=>17, 'start_date'=>'2024-8-07 00:00:00', 
                'end_date'=>'2024-8-14 00:00:00', 'progress'=>0.2, 'parent'=>3],
            ['id'=>8, 'name'=>'Task #2.2', 'user_id'=>18, 'start_date'=>'2024-8-06 00:00:00', 
                'end_date'=>'2024-8-10 00:00:00', 'progress'=>0.9, 'parent'=>3]
        ]);
    }
 }
