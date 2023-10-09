<?php
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Contracts\Permission;
use Tests\TestCase;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    // HasFactory,WithFaker;


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
                // 'roles'=> 'Admin'
        ]);

        // Make a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'user_matricule' => '789012',
            'password' => 'password',
        ]);
        dd($response);
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
            // 'roles'=>'Admin'
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
                $credentials = [
                'user_matricule' => '789012',
                'password' => 'password',
            ];

            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn('token');

            JWTAuth::shouldReceive('user')
                ->once();
                // ->andReturn(User::factory()->create());
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
                    // 'roles'=>'Admin'
                    // Add other required fields
                ]);

            $response = $this->postJson('/api/login', $credentials);

            $response->assertStatus(200);
        }

        public function testJWTAuthFactoryGetTTLMethodCalledToRetrieveTokenExpirationTime()
        {
            $credentials = [
                'email' => 'test@example.com',
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

        public function testResponseBuilderSuccessCalledWithCorrectParametersWhenLoginSucceeds()
        {
            $credentials = [
                'email' => 'test@example.com',
                'password' => 'password',
            ];

            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn('token');

            Auth::shouldReceive('user')
                ->once()
                ->andReturn(User::factory()->create());

            JWTAuth::shouldReceive('factory->getTTL')
                ->once()
                ->andReturn(60);

            ResponseBuilder::shouldReceive('success')
                ->once()
                ->with([
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'position',
                        'department',
                        'lineManager',
                        'roles',
                    ],
                    'token' => 'token',
                    'expiration' => 60,
                ], 200)
                ->andReturn(['success' => true, 'code' => 200, 'data' => []]);

            $response = $this->postJson('/api/login', $credentials);

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'code',
                    'locale',
                    'message',
                    'data',
                ]);
        }

        public function testResponseJsonStructureContainsAllRequiredFieldsAndDataAfterSuccessfulLogin()
        {
            $credentials = [
                'email' => 'test@example.com',
                'password' => 'password',
            ];

            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn('token');

            Auth::shouldReceive('user')
                ->once()
                ->andReturn(User::factory()->create());

            JWTAuth::shouldReceive('factory->getTTL')
                ->once()
                ->andReturn(60);

            ResponseBuilder::shouldReceive('success')
                ->once()
                ->with([
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'position',
                        'department',
                        'lineManager',
                        'roles',
                    ],
                    'token' => 'token',
                    'expiration' => 60,
                ], 200)
                ->andReturn(['success' => true, 'code' => 200, 'data' => []]);

            $response = $this->postJson('/api/login', $credentials);

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'code',
                    'locale',
                    'message',
                    'data' => [
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
                    ],
                ]);
        }

        public function testResponseJsonStructureContainsCorrectErrorMessageWhenLoginFails()
        {
            $credentials = [
                'email' => 'test@example.com',
                'password' => 'incorrect_password',
            ];

            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn(false);

            ResponseBuilder::shouldReceive('error')
                ->once()
                ->with(400, [''], ['Invalid Credentials'])
                ->andReturn(['success' => false, 'code' => 400, 'message' => ['Invalid Credentials']]);

            $response = $this->postJson('/api/login', $credentials);

            $response->assertStatus(400)
                ->assertJson([
                    'message' => ['Invalid Credentials'],
                ]);
        }

        public function testResponseJsonStructureContainsCorrectErrorCodeWhenLoginFails()
        {
            $credentials = [
                'email' => 'test@example.com',
                'password' => 'incorrect_password',
            ];

            JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn(false);

            ResponseBuilder::shouldReceive('error')
                ->once()
                ->with(400, [''], ['Invalid Credentials'])
                ->andReturn(['success' => false, 'code' => 400, 'message' => ['Invalid']]);
            }
}
