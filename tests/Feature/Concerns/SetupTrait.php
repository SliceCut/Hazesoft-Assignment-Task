<?php
namespace Tests\Feature\Concerns;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

trait SetupTrait {

    public function setup(): void
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }
}
