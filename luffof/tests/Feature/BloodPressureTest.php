<?php

namespace Tests\Feature;

use App\Models\BloodPressure;
use App\Models\User;
use Tests\TestCase;

class BloodPressureTest extends TestCase
{
    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['name' => 'Admin User', 'email' => 'admin@example.com']);
        $this->user = User::factory()->create(['name' => 'Test User', 'email' => 'test@example.com']);
    }

    public function test_bp_route_exists(): void
    {
        $response = $this->get('/bp');
        $response->assertStatus(302); // Redirect to login
        $response->assertRedirect('/login');
    }

    public function test_bp_index_requires_authentication(): void
    {
        $response = $this->actingAs($this->admin)->get('/bp');
        $response->assertStatus(200);
    }

    public function test_bp_index_shows_blood_pressure_records(): void
    {
        BloodPressure::create([
            'user_id' => $this->admin->id,
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'Morning reading',
        ]);

        $response = $this->actingAs($this->admin)->get('/bp');
        $response->assertStatus(200);
        $response->assertSee('Blood Pressure Records');
    }

    public function test_bp_index_with_no_records(): void
    {
        $response = $this->actingAs($this->admin)->get('/bp');
        $response->assertStatus(200);
        $response->assertSee('No blood pressure records yet');
    }

    public function test_bp_create_route_exists(): void
    {
        $response = $this->actingAs($this->admin)->get('/bp/create');
        $response->assertStatus(200);
    }

    public function test_bp_create_form(): void
    {
        $response = $this->actingAs($this->admin)->get('/bp/create');
        $response->assertSee('systolic')
                ->assertSee('diastolic')
                ->assertSee('notes');
    }

    public function test_bp_create_store_invalid_data(): void
    {
        $response = $this->actingAs($this->admin)->post('/bp', [
            'systolic' => 'invalid',
            'diastolic' => 80,
        ]);

        $response->assertStatus(302); // Redirect back with error
        $response->assertSessionHasErrors(['systolic' => true]);
    }

    public function test_bp_create_store_valid_data(): void
    {
        $response = $this->actingAs($this->admin)->post('/bp', [
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'Morning reading',
        ]);

        $response->assertRedirect('/bp');
        $this->assertDatabaseCount('blood_pressures', 1);
    }

    public function test_bp_index_after_create(): void
    {
        $this->actingAs($this->admin)->get('/bp/create');
        $this->actingAs($this->admin)->post('/bp', [
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'New reading',
        ]);

        $response = $this->actingAs($this->admin)->get('/bp');
        $response->assertStatus(200);
        $response->assertSee('120');
    }

    public function test_bp_show_route(): void
    {
        $bp = BloodPressure::create([
            'user_id' => $this->admin->id,
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'Morning',
        ]);

        $response = $this->actingAs($this->admin)->get("/bp/{$bp->id}");
        $response->assertStatus(200);
        $response->assertSee('Blood Pressure Reading');
    }

    public function test_bp_show_status_colors(): void
    {
        // Normal BP
        $normal = BloodPressure::create(['user_id' => $this->admin->id, 'systolic' => 110, 'diastolic' => 70, 'notes' => '']);
        $response = $this->actingAs($this->admin)->get("/bp/{$normal->id}");
        $response->assertStatus(200);

        // High BP
        $high = BloodPressure::create(['user_id' => $this->admin->id, 'systolic' => 140, 'diastolic' => 90, 'notes' => '']);
        $highResponse = $this->actingAs($this->admin)->get("/bp/{$high->id}");
        $highResponse->assertStatus(200);
    }

    public function test_bp_edit_route(): void
    {
        $bp = BloodPressure::create([
            'user_id' => $this->admin->id,
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'Morning',
        ]);

        $response = $this->actingAs($this->admin)->get("/bp/{$bp->id}/edit");
        $response->assertStatus(200);
    }

    public function test_bp_edit_form_populated(): void
    {
        $bp = BloodPressure::create([
            'user_id' => $this->admin->id,
            'systolic' => 125,
            'diastolic' => 82,
            'notes' => 'Lunchtime reading',
        ]);

        $response = $this->actingAs($this->admin)->get("/bp/{$bp->id}/edit");
        $response->assertStatus(200);
        $response->assertSee('125')
                ->assertSee('82')
                ->assertSee('Lunchtime reading');
    }

    public function test_bp_update_invalid_data(): void
    {
        $bp = BloodPressure::create([
            'user_id' => $this->admin->id,
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'Original notes',
        ]);

        $response = $this->actingAs($this->admin)->put("/bp/{$bp->id}", [
            'systolic' => 'invalid',
            'diastolic' => 80,
            'notes' => 'Updated',
        ]);

        $response->assertSessionHasErrors(['systolic' => true]);
        $this->assertEquals('Original notes', BloodPressure::find($bp->id)->notes);
    }

    public function test_bp_update_valid_data(): void
    {
        $bp = BloodPressure::create([
            'user_id' => $this->admin->id,
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'Original notes',
        ]);

        $response = $this->actingAs($this->admin)->put("/bp/{$bp->id}", [
            'systolic' => 125,
            'diastolic' => 82,
            'notes' => 'Updated notes',
        ]);

        $response->assertRedirect("/bp/{$bp->id}");

        $bp = BloodPressure::find($bp->id);
        $this->assertEquals(125, $bp->systolic);
        $this->assertEquals(82, $bp->diastolic);
        $this->assertEquals('Updated notes', $bp->notes);
    }

    public function test_bp_destroy_route(): void
    {
        $bp = BloodPressure::create([
            'user_id' => $this->admin->id,
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'Morning',
        ]);

        $response = $this->actingAs($this->admin)->delete("/bp/{$bp->id}");
        $response->assertRedirect('/bp');

        $this->assertDatabaseCount('blood_pressures', 0);
    }

    public function test_bp_destroy_only_owner_can_delete(): void
    {
        // Create records for two users
        $bp1 = BloodPressure::create([
            'user_id' => $this->admin->id,
            'systolic' => 120,
            'diastolic' => 80,
            'notes' => 'Admin',
        ]);

        $bp2 = BloodPressure::create([
            'user_id' => $this->user->id,
            'systolic' => 130,
            'diastolic' => 85,
            'notes' => 'User',
        ]);

        // Admin tries to delete user's record
        $response = $this->actingAs($this->admin)->delete("/bp/{$bp2->id}");
        $response->assertSessionHasErrors(['user_id' => 'must be one of: ']);

        // User can delete own record
        $response = $this->actingAs($this->user)->delete("/bp/{$bp2->id}");
        $response->assertRedirect('/bp');
        $this->assertDatabaseCount('blood_pressures', 1); // Only bp1 remains
    }
}
