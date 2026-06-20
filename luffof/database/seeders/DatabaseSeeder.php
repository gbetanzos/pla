<?php

namespace Database\Seeders;

use App\Models\BloodPressure;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create user if not exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                //'password' => '$2y$12$XBradtH2NqSD7GkI2qJPYu6nFBmm3isn6HySiRBrjKEZ9H5gCO2y6',
                'password' => '$2y$12$C7suJPrWEb468APnPqSLD.k6f9WX08pCruxfAu4hbba.9gz23lFGq',
                
            ]
        );

        // Sample blood pressure readings
        for ($i = 0; $i < 5; $i++) {
            BloodPressure::create([
                'user_id' => $user->id,
                'systolic' => rand(100, 160),
                'diastolic' => rand(60, 100),
                'notes' => null,
            ]);
        }
    }
}
