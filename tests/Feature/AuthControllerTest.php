<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Add any necessary setup code here, like creating roles or permissions.
    }

    public function testLoginWithValidCredentials()
    {
             // Create a department for testing
         $department = Department::factory()->create();

         // Create a position for testing
         $position = Position::factory()->create();
        // Create a user for testing
        $user = $this->postJson('/api/register',[
                'user_matricule' => '789012',
                'password' => 'password',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => '1234567890',
                'email' => 'john.doe@example.com',
                'departments_id' => $department->id,
                'positions_id' => $position->id,
                'gender' => 'Male',
        ]);

        // Make a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'user_matricule' => '789012',
            'password' => 'password',
        ]);

        // $response->assertStatus(200);
        $response->assertJsonStructure(['success',
            'code',
            'locale',
            'message',
            'data']);
    }

    public function testLoginWithInvalidCredentials()
    {
         // Create a department for testing
        //  $department = Department::factory()->create();

        //  // Create a position for testing
        //  $position = Position::factory()->create();
        // // Create a user for testing
        // $user = $this->postJson([
        //         'user_matricule' => '789012',
        //         'password' => 'password',
        //         'first_name' => 'John',
        //         'last_name' => 'Doe',
        //         'phone' => '1234567890',
        //         'email' => 'john.doe@example.com',
        //         'departments_id' => $department->id,
        //         'positions_id' => $position->id,
        //         'gender' => 'Male',
        // ]);

        // Make a POST request to the login endpoint with incorrect password
        $response = $this->postJson('/api/login', [
            'user_matricule' => '123456',
            'password' => 'incorrect_password',
        ]);

        $response->assertStatus(400)
            ->assertJsonStructure(['success',
            'code',
            'locale',
            'message',
            'data',]);
    }

    public function testRegister()
    {
        // Create a department for testing
        $department = Department::factory()->create();

        // Create a position for testing
        $position = Position::factory()->create();

        // Make a POST request to the register endpoint
        $response = $this->postJson('/api/register', [
            'user_matricule' => '789012',
            'password' => 'password',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '1234567890',
            'email' => 'john.doe@example.com',
            'departments_id' => $department->id,
            'positions_id' => $position->id,
            'gender' => 'Male',
            // Add other required fields
        ]);

        $response->assertStatus(201)
        //     ->assertJsonStructure(['user']);
       ->assertJsonStructure([
            'success',
            'code',
            'locale',
            'message',
            'data',
        ]);
    }

    // Add test cases for other controller methods...
}
