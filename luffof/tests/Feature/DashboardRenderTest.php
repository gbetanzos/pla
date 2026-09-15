<?php

namespace Tests;

use App\Models\User;

class DashboardRenderTest extends TestCase
{
    public function test_dashboard_renders(): void
    {
        $user = User::factory()->create();
        for ($i = 0; $i < 5; $i++) {
            $user->bloodPressures()->create([
                'systolic' => 100 + $i * 5,
                'diastolic' => 70 + $i * 3,
                'notes' => null,
                'created_at' => now()->startOfDay()->subDays($i),
            ]);
        }

        $this->actingAs($user)->get('/dashboard', ['range' => 'monthly']);
        $this->assertSee('BP Trends');
        $this->assertSee('Systolic (mmHg)');
    }

    public function test_dashboard_empty_period_renders(): void
    {
        // user with only this-month readings to trigger empty period
        $user = User::factory()->create();
        User::firstOrNew($user)->bloodPressures()->create([
            'systolic' => 120, 'diastolic' => 80, 'notes' => null,
            'created_at' => now()->subYear()->startOfMonth(),
        ]);

        $res = $this->actingAs($user)->get('/dashboard', ['range' => 'monthly']);
        $this->assertSee('No blood pressure readings in the selected period.');
    }
}
