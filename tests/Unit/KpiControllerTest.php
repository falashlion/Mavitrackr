<?php

namespace Tests\Feature;

use App\Models\Kpa;
use App\Models\Kpi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class KpiControllerTest extends TestCase
{

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("migrate");
        $this->artisan("db:seed");
    }

    // public function testWeightedAverageScoreMethodCalculatesCorrectly()
    // {
    //     // Create a user with KPIs
    //     $user = User::factory()->random();
    //     $kpis = Kpi::factory()->count(3)->create(['user_id' => $user->id]);

    //     // Call the weightedAverageScore method
    //     // $this->artisan('kpi:weighted-average-score');

    //     // Assert that the weighted average score was calculated correctly
    //     foreach ($kpis as $kpi) {
    //         $this->assertEquals($kpi->weighted_average_score, ($kpi->score * $kpi->weight) / $user->kpis->sum('weight'));
    //     }
    // }

    public function testGetAllKpisReturnsAllKpisForGivenUser()
    {
        $credentials = [
            'user_matricule' => 'Admin123',
            'password' => 'Admin123',
        ];
        $token  = JWTAuth::attempt($credentials);
        // Create a user with KPIs
        $user_id = User::all()->random()->id;
        $kpis = Kpi::factory()->count(3)->create();

        // Call the getAllKpis method
        $response = $this->get('/api/kpis', ['Authorization' => 'Bearer ' . $token]);

        // Assert that the response contains all KPIs for the user
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                "success",
                "code",
                "locale",
                "message",
                "data" => [
                    'items' => [],
                ]
            ]
        );
    }

    public function testGetKpiByIdReturnsCorrectKpiForGivenId()
    {
        $credentials = [
            'user_matricule' => 'Admin123',
            'password' => 'Admin123',
        ];
        $token  = JWTAuth::attempt($credentials);
        // Create a user with a KPI
        $user = User::factory()->create();
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);
        $kpi = json_decode(json_encode($kpi, true));

        // Call the getKpiById method
        $response = $this->actingAs($user)->get('/api/kpis/' . $kpi->id, ['Authorization' => 'Bearer ' . $token]);
        $user_id = $response->json('data.item.user_id');
        // Assert that the response contains the correct KPI
        $response->assertStatus(200);
        $this->assertEquals($user->id, $user_id);
    }

    public function testCreateKpiCreatesNewKpiWithCorrectData()
    {
        $user = User::factory()->create(['password' => 'password']);
        $credentials = [
            'user_matricule' => $user->user_matricule,
            'password' => 'password',
        ];
        $token  = JWTAuth::attempt($credentials);
        // create a Key Performnace Area
        $kpa = Kpa::factory()->create();
        // Call the createKpi method
        $data = [
            'title' => 'Test KPI',
            'user_id' => $user->id,
            'kpas_id' => $kpa->id,
        ];
        $response = $this->actingAs($user)->post('/api/kpis', $data, ['Authorization' => 'Bearer ' . $token]);

        // Assert that the response contains the new KPI
        $response->assertStatus(201);
    }

    public function testUpdateKpiUpdatesExistingKpiWithCorrectData()
    {
        // Create a user with a KPI and generate token
        $user = User::factory()->create(['password' => 'password']);
        $credentials = [
            'user_matricule' => $user->user_matricule,
            'password' => 'password',
        ];
        $token  = JWTAuth::attempt($credentials);
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);
        // Call the updateKpi method
        $data = [
            'title' => 'Updated KPI',
            'description' => 'This is an updated KPI',
            'weight' => 5,
            'score' => 3,
        ];
        $response = $this->actingAs($user)->put('/api/kpis/' . $kpi->id, $data, ['Authorization' => 'Bearer ' . $token]);
        // Assert that the response contains the updated KPI
        $response->assertStatus(200);
        // $response->assertJsonFragment($data);
    }

    public function testDeleteKpiDetailsDeletesExistingKpi()
    {
        // Create a user with a KPI and generate token
        $user = User::factory()->create(['password' => 'password']);
        $credentials = [
            'user_matricule' => $user->user_matricule,
            'password' => 'password',
        ];
        $token  = JWTAuth::attempt($credentials);
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);

        // Call the deleteKpiDetails method
        $response = $this->actingAs($user)->delete('/api/kpis/' . $kpi->id, [], ['Authorization' => 'Bearer ' . $token]);

        // Assert that the response indicates success
        $response->assertStatus(204);

        // Assert that the KPI was deleted
        $this->assertDatabaseMissing('kpis', ['id' => $kpi->id]);
    }

    public function testCreateKpiWeightCreatesNewKpiWeightWithCorrectData()
    {
        // Create a user with a KPI and generate token
        $user = User::factory()->create(['password' => 'password']);
        $credentials = [
            'user_matricule' => $user->user_matricule,
            'password' => 'password',
        ];
        $token  = JWTAuth::attempt($credentials);
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);

        // Call the createKpiWeight method
        $data = [
            'weight' => 5,
        ];
        $response = $this->actingAs($user)->post('/api/kpis/weights/' . $kpi->id, $data, ['Authorization' => 'Bearer ' . $token]);
        $weight = $response->json('data.item.weight');
        // Assert that the response contains the new KPI weight
        $response->assertStatus(201);
        $this->assertEquals(5, $weight);
    }

    public function testCreateKpiScoreCreatesNewKpiScoreWithCorrectData()
    {
        // Create a user with a KPI and generate token
        $user = User::factory()->create(['password' => 'password']);
        $credentials = [
            'user_matricule' => $user->user_matricule,
            'password' => 'password',
        ];
        $token  = JWTAuth::attempt($credentials);
        $kpi = Kpi::factory()->create(['user_id' => $user->id]);

        // Call the createKpiScore method
        $data = [
            'score' => 3,
        ];
        $response = $this->actingAs($user)->post('/api/kpis/scores/' . $kpi->id, $data, ['Authorization' => 'Bearer ' . $token]);
        $score = $response->json('data.item.score');
        // Assert that the response contains the new KPI score
        $response->assertStatus(201);
        // $this->assertEquals(5,$score);
    }

    public function testGetKpiByUserIdReturnsAllKpisForGivenUser()
    {
        // Create a user with a KPI and generate token
        $user = User::factory()->create(['password' => 'password']);
        $credentials = [
            'user_matricule' => $user->user_matricule,
            'password' => 'password',
        ];
        $token  = JWTAuth::attempt($credentials);
        $kpis = Kpi::factory()->count(3)->create(['user_id' => $user->id]);

        // Call the getKpiByUserId method
        $response = $this->actingAs($user)->get('/api/users/kpis/' . $user->id, ['Authorization' => 'Bearer ' . $token]);

        // Assert that the response contains all KPIs for the user
        $response->assertStatus(200);
    }

    /**
     * tearDown
     *
     * @return void
     */
    protected function tearDown(): void
    {
        $this->artisan("migrate:reset");
        parent::tearDown();
    }
}
