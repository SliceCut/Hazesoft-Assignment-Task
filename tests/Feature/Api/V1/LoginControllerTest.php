<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_can_login_successfully()
    {
        $data = [
            'email' => 'hazesoft@gmail.com',
            'password' => 'admin124',
        ];
        $response = $this->post(route('api.v1.login'),$data);

        $response->assertStatus(function(AssertableJson $json) use($data) {
            $json->where('user.email', $data['email'] )
                ->whereType('token','string');
        });
    }
}
