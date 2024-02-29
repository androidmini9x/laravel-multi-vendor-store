<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
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

        // Store::factory(5)->create();
        // Category::factory(10)->create();
        // Product::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'admin1',
        //     'email' => 'admin1@admin.com',
        //     'password' => Hash::make('admin'),
        // ]);
        // $this->call(UserSeeder::class);

        \App\Models\Admin::factory(4)->create();
    }
}
