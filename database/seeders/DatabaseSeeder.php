<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        User::create([
            'email'=>"tosin@user.com",
            'username'=> 'tosmic',
            "password"=>Hash::make('vinny'),
            "is_active"=> 1,
        ]);
        User::create([
            'email'=>"vinny@user.com",
            'username'=> 'vinny',
            "password"=>Hash::make('vinny'),
            "is_active"=> 1,
        ]);

        Admin::create([
            'email'=>"vincent@admin.com",
            'username'=> 'vincent',
            "password"=>Hash::make('vinny'),
            
        ]);
        Admin::create([
            'email'=>"tosin@admin.com",
            'username'=> 'tosin',
            "password"=>Hash::make('vinny'),
           
        ]);
    }
}
