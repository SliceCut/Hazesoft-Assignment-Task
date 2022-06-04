<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    public function test_it_can_fetch_company_list()
    {
        $response = $this->get('/api/v1/companies', [
            'perPage' => 1,
        ]);

        $response->assertStatus(200);
    }
}
