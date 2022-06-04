<?php

namespace Tests\Feature\Api\V1;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Concerns\SetupTrait;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;
    use SetupTrait;

    public function test_it_can_fetch_employee_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get("/api/v1/employees?perPage=1");

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

    public function test_it_can_create_new_employee()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $employee = Employee::factory()->count(1)->make()->first()->toArray();

        $response = $this->post("/api/v1/employees", $employee);

        $response->assertJson(function (AssertableJson $json) use ($employee) {
            $json->hasAll([
                "data",
                "message"
            ])
            ->where("data.name", $employee["name"])
            ->where("data.enroll_id", $employee["enroll_id"])
            ->where("data.email", $employee["email"]);
        });
    }

    public function test_it_will_fail_to_create_new_employee()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $employee = Employee::factory()->count(1)->make()->first()->toArray();
        $response = $this->json("POST", "/api/v1/employees", Arr::except($employee, ['name','enroll_id']));
        $response->assertStatus(422);
    }

    public function test_it_can_update_employee()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();

        $response = $this->json("PATCH", "/api/v1/employees/{$employee->id}", array_merge(
            $employee->toArray(),
            [
                'name' => 'John Doe'
            ]
        ));
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Employee updated successfully']);
    }

    public function test_it_can_delete_employee()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $employee = Employee::factory()->create();
        $response = $this->json("DELETE", "/api/v1/employees/{$employee->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Employee deleted successfully']);
    }
}
