<?php

namespace Tests\Feature\Api\V1;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Concerns\SetupTrait;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;
    use SetupTrait;

    public function test_it_can_fetch_department_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get("/api/v1/departments?perPage=1");

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                "data",
                "message",
                "total",
                "current_page",
                "perPage",
                "lastPage"
            ])
            ->has('data', 1);
        });
    }

    public function test_it_can_fetch_employee_list_of_department()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $department = Department::firstOrFail();
        $response = $this->get("/api/v1/departments/{$department->id}/employees?perPage=1");
        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll([
                "data",
                "message",
                "total",
                "current_page",
                "perPage",
                "lastPage"
            ])
            ->has('data', 1);
        });
    }

    public function test_it_can_create_new_department()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $department = Department::factory()->count(1)->make()->first()->toArray();

        $response = $this->post("/api/v1/departments", $department);
        $response->assertJson(function (AssertableJson $json) use ($department) {
            $json->hasAll([
                "data",
                "message"
            ])
            ->where("data.name", $department["name"])
            ->where("data.company_id", $department["company_id"]);
        });
    }

    public function test_it_will_fail_to_create_new_department()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $department = [
            'name' => 'Android Department 1',
        ];
        $response = $this->json("POST","/api/v1/departments", $department);
        $response->assertStatus(422);
    }

    public function test_it_can_update_department()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $department = Department::factory()->create();
        $response = $this->json("PATCH","/api/v1/departments/{$department->id}", [
            'name' => "Test Department section",
            'company_id' => $department->company_id,
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Department updated successfully']);

    }

    public function test_it_can_delete_department()
    {
        $user = User::factory()->create();
        $this->actingAs($user);   

        $department = Department::factory()->create();
        $response = $this->json("DELETE","/api/v1/departments/{$department->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Department deleted successfully']);

    }
}
