<?php

namespace Database\Seeders;

use App\Models\BloodPressure;
use App\Models\User;
use Illuminate\Database\Seeder;

class BPSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = User::take(3)->get();

        foreach ($users->slice(0, 2) as $user) {
            foreach (range(1, 5) as $index) {
                BloodPressure::create([
                    'user_id' => $user->id,
                    'systolic' => 110 + ($user->id + $index) * 5,
                    'diastolic' => 70 + ($user->id + $index) * 4,
                    'notes' => $index % 2 === 0 ? 'After morning coffee' : 'Morning reading',
                ]);
            }
        }
    }
}