<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Costumer;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $branch = Branch::create([
            'name' => 'Toko 1',
            'address' => 'Jakarta,Jejo,Indonesia',
            'phone' => '081226271819'
        ]);


        User::factory()->create([
            'name' => 'Test User',
            'branch_id' => $branch->id,
            'email' => 'test@example.com',
            'role' => 'superadmin'
        ]);

        Costumer::create([
            'name' => 'Anonim',
            'phone' => '081336920647',
            'address' => ''
        ]);
        
    }
}
