<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserInformatinoTest extends TestCase
{
    use RefreshDatabase;
     /**
     * sets up the seeders for the test
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan("migrate");
        $this->artisan("db:seed");
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
     /**
     * Test Database if it is being seeded with the required information
     *
     * @return void
     */
    public function testDatabase(){

        $this->assertDatabaseHas('users',['user_matricule'=>'Admin123']);
    }

    /**
     * tearDown
     *
     * @return void
     */
    protected function tearDown():void{
        $this->artisan("migrate:reset");
        parent::tearDown();
    }
}
