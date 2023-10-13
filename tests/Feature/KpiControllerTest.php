<?php

namespace Tests\Feature;

use App\Models\Kpi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KpiControllerTest extends TestCase
{
    use RefreshDatabase, HasFactory, Notifiable;

    public static function createUser($attributes = [])
    {
        $user = new User;

        $user->password = Hash::make($attributes['password']);
        $user->user_matricule = $attributes['user_matricule'];
        $user->profile_image = $attributes['profile_image'];
        $user->first_name = $attributes['first_name'];
        $user->last_name = $attributes['last_name'];
        $user->phone = $attributes['phone'];
        $user->address = $attributes['address'];
        $user->line_manager = $attributes['line_manager'];
        $user->gender = $attributes['gender'];
        $user->email = $attributes['email'];
        $user->departments_id = $attributes['departments_id'];
        $user->positions_id = $attributes['positions_id'];

        $user->save();

        return $user;
    }

    public function testWeightedAverageScoreMethodCalculatesCorrectly()
    {
        // Create a user with KPIs
        $user = User::factory()->create();
        $kpis = Kpi::factory()->count(3)->create(['user_id' => $user->id]);

        // Call the weightedAverageScore method
        $this->artisan('kpi:weighted-average-score');

        // Assert that the weighted average score was calculated correctly
        foreach ($kpis as $kpi) {
            $this->assertEquals($kpi->weighted_average_score, ($kpi->score * $kpi->weight) / $user->kpis->sum('weight'));
        }
    }

    public function testGetAllKpisReturnsAllKpisForGivenUser()
    {
        // Create a user with KPIs
        // $user = User::factory()->create();
        $this->seed();
        $user = $this->createUser([

            'password' => 'password123',
            'user_matricule' => '12345',
            'profile_image' => 'profile.jpg',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '555-555-5555',
            'address' => '123 Main St',
            'line_manager' => 1,
            'gender' => 'male',
            'email' => 'john.doe@example.com',
            'departments_id' => 1,
            'positions_id' => 1,
        ]);
        $kpis = Kpi::factory()->count(3)->create(['user_id' => $user->id]);

        // Call the getAllKpis method
        $response = $this->actingAs($user)->get('/api/kpis');

        // Assert that the response contains all KPIs for the user
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function testGetKpiByIdReturnsCorrectKpiForGivenId()
    {
        // Create a user with a KPI
        $user = User::factory()->create();
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);

        // Call the getKpiById method
        $response = $this->actingAs($user)->get('/api/kpis/' . $kpi->id);

        // Assert that the response contains the correct KPI
        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $kpi->id]);
    }

    public function testCreateKpiCreatesNewKpiWithCorrectData()
    {
            // Create a user
            $user = User::create([
                'password' => 'password123',
                'user_matricule' => '12345',
                'profile_image' => 'profile.jpg',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => '555-555-5555',
                'address' => '123 Main St',
                'line_manager' => 1,
                'gender' => 'male',
                'email' => 'john.doe@example.com',
                'departments_id' => 1,
                'positions_id' => 1,
            ]);

            // Call the createKpi method
            $data = [
                'title' => 'Test KPI',
                'description' => 'This is a test KPI',
                'weight' => 10,
                'score' => 5,
            ];
            $response = $this->actingAs($user)->post('/api/kpis', $data);

            // Assert that the response contains the new KPI
            $response->assertStatus(201);
            $response->assertJsonFragment($data);
    }

    public function testUpdateKpiUpdatesExistingKpiWithCorrectData()
    {
        // Create a user with a KPI
        $user = User::factory()->create();
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);

        // Call the updateKpi method
        $data = [
            'title' => 'Updated KPI',
            'description' => 'This is an updated KPI',
            'weight' => 5,
            'score' => 3,
        ];
        $response = $this->actingAs($user)->put('/api/kpis/' . $kpi->id, $data);

        // Assert that the response contains the updated KPI
        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    public function testDeleteKpiDetailsDeletesExistingKpi()
    {
        // Create a user with a KPI
        $user = User::factory()->create();
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);

        // Call the deleteKpiDetails method
        $response = $this->actingAs($user)->delete('/api/kpis/' . $kpi->id);

        // Assert that the response indicates success
        $response->assertStatus(204);

        // Assert that the KPI was deleted
        $this->assertDatabaseMissing('kpis', ['id' => $kpi->id]);
    }

    public function testCreateKpiWeightCreatesNewKpiWeightWithCorrectData()
    {
        // Create a user with a KPI
        $user = User::factory()->create();
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);

        // Call the createKpiWeight method
        $data = [
            'weight' => 5,
        ];
        $response = $this->actingAs($user)->post('/api/kpis/' . $kpi->id . '/weight', $data);

        // Assert that the response contains the new KPI weight
        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function testCreateKpiScoreCreatesNewKpiScoreWithCorrectData()
    {
        // Create a user with a KPI
        $user = User::factory()->create();
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);

        // Call the createKpiScore method
        $data = [
            'score' => 3,
        ];
        $response = $this->actingAs($user)->post('/api/kpis/' . $kpi->id . '/score', $data);

        // Assert that the response contains the new KPI score
        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function testGetKpiByUserIdReturnsAllKpisForGivenUser()
    {
        // Create a user with KPIs
        $user = User::factory()->create();
        $kpis = Kpi::factory()->count(3)->create(['user_id' => $user->id]);

        // Call the getKpiByUserId method
        $response = $this->actingAs($user)->get('/api/users/' . $user->id . '/kpis');

        // Assert that the response contains all KPIs for the user
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function testGetAllReturnsAllKpisForGivenUser()
    {
        // Create a user with KPIs
        $user = User::factory()->create();
        $kpis = Kpi::factory()->count(3)->create(['user_id' => $user->id]);

        // Call the getAll method
        $result = $this->app->make('App\Interfaces\KpiRepositoryInterface')->getAll($user->id);

        // Assert that the result contains all KPIs fhttps://maprketplace.visualstudio.com/items?itemName=GitHub.copilotor the user
        // $this->
    }
}
