<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Concerns\SetupTrait;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    use SetupTrait;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_can_login_successfully()
    {
        $data = [
            'email' => 'hazesoft@gmail.com',
            'password' => 'admin123',
        ];
        $response = $this->post(route('api.v1.login'), $data);

        $response->assertJson(function (AssertableJson $json) use ($data) {
            $json->where('user.email', $data['email'])
                ->whereType('token', 'string');
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_will_login_authentication_fail()
    {
        $data = [
            'email' => 'hazesoft@gmail.com',
            'password' => 'admin125454',
        ];
        $response = $this->post(route('api.v1.login'), $data);

        $response->assertStatus(401);
    }
}
