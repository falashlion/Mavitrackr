<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Support\Facades\Config;
use Tests\CreatesApplication;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use PHPOpenSourceSaver\JWTAuth\JWT;
use PHPOpenSourceSaver\JWTAuth\JWTAuth as JWTAuthJWTAuth;

class AuthControllerTest extends TestCase
{
   public array $JWTuser = [];


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
     * Test Database if it is being seeded with the required information
     *
     * @return void
     */
    public function testDatabase(){
        $this->assertDatabaseHas('users',['user_matricule'=>'Admin123']);
    }

    /**
     * testLoginWithValidCredentials
     *
     * @return void
     */
    public function testLoginWithValidCredentials():void
    {
        $baseUrl = Config::get('app.url') .'/api/login';
        // Make a POST request to the login endpoint
        $response = $this->post($baseUrl, [
            'user_matricule' => 'Admin123',
            'password' => 'Admin123',
         ]);
        $response->assertStatus(200)
        ->assertJsonStructure(['success',
            'code',
            'locale',
            'message',
            'data'=> [
                'user' => [
                    'id',
                    "first_name",
                    "last_name",
                    'email',
                    'position',
                    'department',
                    'line_manager',
                    'roles',
                ],
            'token',
            'expiration',
            ],]);
    }

    /**
     * testLoginWithInvalidCredentials
     *
     * @return void
     */
    public function testLoginWithInvalidCredentials():void
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

    /**
     * testRegisterMethod
     *
     * @return void
     */
    public function testRegisterMethod():void
    {
        $credentials = [
            'user_matricule' => 'Admin123',
            'password' => 'Admin123',
        ];
        $token  = JWTAuth::attempt($credentials);
        $position = Position::all()->random()->id;
        $department = Department::all()->random()->id;
        // Make a POST request to the register endpoint
        $response = $this->postJson('/api/register', [
            'user_matricule' => 'johndoe123',
            'password' => 'password',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '6567890986',
            'email' => 'john.doe@example.com',
            'departments_id' => $department,
            'positions_id' => $position,
            'gender' => 'Male',
            'roles'=>'Admin'
        ],['Authorization' => 'Bearer '.$token]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'code',
                'locale',
                'message',
                'data'
            ]);
    }

        /**
         * testJWTAuthAttemptCalledWithCorrectCredentials
         *
         * @return void
         */
        public function testJWTAuthAttemptCalledWithCorrectCredentials():void
        {
            $credentials = [
                'user_matricule' => 'Admin123',
                'password' => 'Admin123',
            ];
            $token  = JWTAuth::attempt($credentials);
            $response = $this->postJson('/api/login', $credentials,['Authorization' => 'Bearer '.$token]);

            $response->assertStatus(200);
        }

        public function testResponseBuilderErrorCalledWithCorrectParametersWhenLoginFails()
        {
            $credentials = [
                'user_matricule' => 'test@example.com',
                'password' => 'incorrect_password',
            ];
            $token = JWTAuth::shouldReceive('attempt')
                ->once()
                ->with($credentials)
                ->andReturn(false);
            $response = $this->postJson('/api/login', $credentials,);
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
            $credentials = [
                'user_matricule' => 'Admin123',
                'password' => 'Admin123',
            ];
            $response = $this->postJson("api/login/", $credentials,);
            $user = $response->json('data.user');
            $userinfo = JWTAuth::user();
            $userArray = json_decode(json_encode($userinfo), true);
            $this->assertEquals($user,$userArray);
        }

        public function testJWTAuthFactoryGetTTLMethodCalledToRetrieveTokenExpirationTime()
        {
            $credentials = [
                'user_matricule' => 'Admin123',
                'password' => 'Admin123',
            ];
            $token = JWTAuth::attempt($credentials);
            $TTL = JWTAuth::factory()->getTTL()*60;
            $this->assertTrue(is_int($TTL));
        }

        public function testResponseJsonStructureContainsAllRequiredFieldsAndDataAfterSuccessfulLogin()
        {
            $credentials = [
                'user_matricule' => "Admin123",
                'password' => "Admin123",
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
            $response = $this->postJson('/api/login', $credentials);
            $response->assertStatus(400)
                ->assertJson([
                    'message' => 'Error #400',
                ]);
            }

    /**
     * tearDown
     *
     * @return void
     */
    protected function tearDown():void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
