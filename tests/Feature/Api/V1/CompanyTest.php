<?php

namespace Tests\Feature\Api\V1;

use App\Domain\Repositories\Company\CompanyRepositoryInterface;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Concerns\SetupTrait;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;
    use SetupTrait;

    public function test_it_can_fetch_company_list()
    {
        $response = $this->get("/api/v1/companies", [
            "perPage" => 1
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                "data",
                "message",
                "total",
                "current_page",
                "perPage",
                "lastPage"
            ]);
        });
    }

    public function test_it_can_fetch_employee_list_of_company()
    {
        $company = Company::firstOrFail();
        $response = $this->get("/api/v1/companies/{$company->id}/employees", [
            "perPage" => 1
        ]);
        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                "data",
                "message",
                "total",
                "current_page",
                "perPage",
                "lastPage"
            ]);
        });
    }

    public function test_it_can_create_new_company()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = [
            "name" => "Hazesoft Company",
            "email" => "hszesoftcomapany1@gmail.com",
            "location" => "New York",
            "contact_number" => "09244242"
        ];

        $response = $this->post("/api/v1/companies", $company);

        $response->assertJson(function (AssertableJson $json) use ($company) {
            $json->hasAll([
                "data",
                "message"
            ])
            ->where("data.name", $company["name"])
            ->where("data.email", $company["email"])
            ->where("data.location", $company["location"])
            ->where("data.contact_number", $company["contact_number"]);
        });
    }

    public function test_it_will_fail_to_create_new_company()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $company = [
            'location' => 'New York',
            'contact_number' => '32424324'
        ];
        $response = $this->json("POST", "/api/v1/companies", $company);
        $response->assertStatus(422);
    }

    public function test_it_can_update_company()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();
        $response = $this->json("PATCH", "/api/v1/companies/{$company->id}", [
            'name' => $company->name,
            'email' => $company->email,
            'location' => 'John Doe Test',
            'contact_number' => '32424324'
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Company updated successfully']);
    }

    public function test_it_can_delete_company()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create();
        $response = $this->json("DELETE", "/api/v1/companies/{$company->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Company deleted successfully']);
    }
}
