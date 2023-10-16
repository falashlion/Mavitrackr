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
        $user = User::factory()->create();
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
            $user = User::factory()->create();
            // Call the createKpi method
            $data = [
                'title' => 'Test KPI',
                'weight' => 10,
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
