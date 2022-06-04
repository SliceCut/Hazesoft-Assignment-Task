<?php

namespace Tests\Feature\Api\V1;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Concerns\SetupTrait;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    use SetupTrait;

    public function test_it_can_fetch_company_list()
    {
        $response = $this->get('/api/v1/companies', [
            'perPage' => 1
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                'data',
                'message',
                'total',
                'current_page',
                'perPage',
                'lastPage'
            ]);
        });
    }

    public function test_it_can_create_new_company()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = Company::factory()
            ->count(1)
            ->make()
            ->first()
            ->toArray();

        $response = $this->post('/api/v1/companies', $company);

        $response->assertJson(function (AssertableJson $json) use ($company) {
            $json->hasAll([
                'data',
                'message',
            ])
            ->where('data.name', $company['name'])
            ->where('data.email', $company['email'])
            ->where('data.location', $company['location']);
        });
    }
}
