<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Junges\Kafka\Facades\Kafka;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    const ROUTE_REGISTER = 'auth.register';

    public $mockConsoleOutput = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prepareDatabase();
    }

    /**
     * @test
     */
    public function will_fail_with_validation_errors_when_email_is_missing()
    {
        Kafka::fake();
        $response = $this->json(
            'POST',
            route(self::ROUTE_REGISTER),
            [
                'password' => 'password',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(
                [
                    'email'
                ]
            );
    }

    /**
     * @test
     */
    public function will_fail_with_validation_errors_when_password_is_missing()
    {
        Kafka::fake();
        $response = $this->json(
            'POST',
            route(self::ROUTE_REGISTER),
            [
                'email' => 'john.doe@email.com',
                'password' => '',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(
                [
                    'password'
                ]
            );
    }

    /**
     * @test
     */
    public function will_fail_with_exist_email()
    {
        Kafka::fake();
        $user = $this->createUser();

        $response = $this->json(
            'POST',
            route(self::ROUTE_REGISTER),
            [
                'name' => 'name',
                'email' => $user->email,
                'password' => 'pass!Word12',
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(
                [
                    'email'
                ]
            );
    }

    /**
     * @test
     */
    public function will_register_successfully_with_correct_credentials()
    {
        Kafka::fake();
        $response = $this->json(
            'POST',
            route(self::ROUTE_REGISTER),
            [
                'name' => 'name',
                'email' => 'email@email.com',
                'password' => 'pa$$!W0rD12',
            ]
        );

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertArrayHasKey('data', $response->json());
        $this->assertArrayHasKey('id', $response->json()['data']);
        $this->assertArrayHasKey('created_at', $response->json()['data']);

        Kafka::assertPublished();
    }
}
