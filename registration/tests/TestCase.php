<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function prepareDatabase()
    {
        $this->artisan('migrate');
    }

    /**
     * Create user
     *
     * @return User
     * @author Mohannad Elemary
     */
    public function createUser($overrides = [])
    {
        return User::factory()->create($overrides);
    }
}
