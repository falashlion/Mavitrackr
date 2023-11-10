<?php
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;


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
                'roles'=> 'Admin'
        ]);

        // Make a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'user_matricule' => '789012',
            'password' => 'password',
        ]);
        $response->assertStatus(200)
        ->assertJsonStructure(['success',
            'code',
            'locale',
            'message',
            'data'=> [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'position',
                    'department',
                    'lineManager',
                    'roles',
                ],
            'token',
            'expiration',
            ],]);

    }

    public function testLoginWithInvalidCredentials()
    {

        // Make a POST request to the login endpoint with incorrect password
        $response = $this->postJson('/api/login', [
            'user_matricule' => '123456',
            'password' => 'incorrect_password',
        ]);

        $response->assertStatus(400)
                ->assertJsonStructure([
                    'success',
                    'code',
                    'locale',
                    'message',
                    'data',
                ])
                ->assertJson([
                    'success' => false,
                    'code' => 400,
                    'locale'=>'en',
                    'message' => 'Error #400',
                ]);
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
            'roles'=>'Admin'
            // Add other required fields
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'code',
                'locale',
                'message',
                'data'
            ]);
    }
    // Add test cases for other controller methods...

        public function testJWTAuthAttemptCalledWithCorrectCredentials()
        {
            $credentials = [
                'user_matricule' => '789012',
                'password' => 'password',
            ];
            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn('token');

            $response = $this->postJson('/api/login', $credentials);

            $response->assertStatus(200);
        }

        public function testResponseBuilderErrorCalledWithCorrectParametersWhenLoginFails()
        {
            $credentials = [
                'user_matricule' => 'test@example.com',
                'password' => 'incorrect_password',
            ];
            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn(false);
            $response = $this->postJson('/api/login', $credentials);
            $response->assertStatus(400)
                ->assertJsonStructure([
                    'success',
                    'code',
                    'locale',
                    'message',
                    'data',
                ])
                ->assertJson([
                    'success' => false,
                    'code' => 400,
                    'locale'=>'en',
                    'message' => 'Error #400',
                ]);
        }

        public function testAuthUserCalledToRetrieveUserObjectAfterSuccessfulLogin()
        {
             // Create a department for testing
            $department = Department::factory()->create();
            // Create a position for testing
            $position = Position::factory()->create();

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
                'roles'=>'Admin'
                // Add other required fields
            ]);
            $credentials = [
                'user_matricule' => '789012',
                'password' => 'password',
            ];
            // JWTAuth::shouldReceive('attempt')
            //     ->once()
            //     ->with($credentials)
            //     ->andReturn('token');

            // JWTAuth::shouldReceive('user')
            //     ->once();
            //     // ->andReturn(User::factory()->create());
            $response = $this->postJson('/api/login', $credentials);

            $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'code',
                'locale',
                'message',
                'data'=>'user',
            ]);
        }

        public function testJWTAuthFactoryGetTTLMethodCalledToRetrieveTokenExpirationTime()
        {
            $credentials = [
                'user_matricule' => '789012',
                'password' => 'password',
            ];
            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn('token');

            JWTAuth::shouldReceive('factory->getTTL')
                ->once()
                ->andReturn(60);

            $response = $this->postJson('/api/login', $credentials);

            $response->assertStatus(200);
        }

        public function testResponseJsonStructureContainsAllRequiredFieldsAndDataAfterSuccessfulLogin()
        {
             // Create a user for testing
             $user = User::factory()->create();

            $credentials = [
                'user_matricule' => $user->user_matricule,
                'password' => $user->password,
            ];
            $response = $this->postJson('/api/login', $credentials);
            $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'code',
                    'locale',
                    'message',
                    'data'
                ]);
        }

        public function testResponseJsonStructureContainsCorrectErrorMessageWhenLoginFails()
        {
            $credentials = [
                'user_matricule' => 'test@example.com',
                'password' => 'incorrect_password',
            ];

            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn(false);

            ResponseBuilder::error(400);
                // ->once()
                // ->with(400, [''], ['Invalid Credentials'])
                // ->andReturn(['success' => false, 'code' => 400, 'message' => ['Error #400']]);
            $response = $this->postJson('/api/login', $credentials);
            $response->assertStatus(400)
                ->assertJson([
                    'message' => 'Error #400',
                ]);
        }

        public function testResponseJsonStructureContainsCorrectErrorCodeWhenLoginFails()
        {
            $credentials = [
                'user_matricule' => 'test@example.com',
                'password' => 'incorrect_password',
            ];

            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn(false);

            $response = $this->postJson('/api/login', $credentials);
            $response->assertStatus(400)
                ->assertJson([
                    'message' => 'Error #400',
                ]);
            }
}
