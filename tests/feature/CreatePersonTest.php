<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CreatePersonTest extends TestCase
{
    /**
     * Create a person with valid data.
     *
     * @return void
     */
    public function testPersonWithValidData()
    {
        $data = [
            'name' => 'John Jacob Jingle-Heimer Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ];

        $response = $this->call('POST', 'http://localhost:8000/api/person', $data, ['Content-Type' => 'application/json']);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'name',
                'birthdate',
                'timezone',
                'interval' => [
                    'y', 'm', 'd', 'h', 'i', 's'
                ],
                'isBirthday',
                'age',
                'message'
            ])
            ->assertJson([
                'name' => 'John Jacob Jingle-Heimer Smith',
                'birthdate' => '1970-01-01',
                'timezone' => 'America/Los_Angeles',
            ]);

        $this->seeInDatabase('people', ['name' => 'John Jacob Jingle-Heimer Smith']);
    }

    /**
     * Create a person with no name.
     *
     * @return void
     */
    public function testPersonWithNoName()
    {
        $data = [
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ];

        $response = $this->call('POST', 'http://localhost:8000/api/person', $data, ['Content-Type' => 'application/json']);

        $response->assertStatus(422);
    }

    /**
     * Create a person with no birthdate.
     *
     * @return void
     */
    public function testPersonWithNoBirthdate()
    {
        $data = [
            'name" => "John Smith',
            'timezone" => "America/Los_Angeles',
        ];

        $response = $this->call('POST', 'http://localhost:8000/api/person', $data, ['Content-Type' => 'application/json']);

        $response->assertStatus(422);
    }

    /**
     * Create a person with no timezone.
     *
     * @return void
     */
    public function testPersonWithNoTimezone()
    {
        $data = [
            'name" => "John Smith',
            'birthdate" => "1970-01-01',
        ];

        $response = $this->call('POST', 'http://localhost:8000/api/person', $data, ['Content-Type' => 'application/json']);

        $response->assertStatus(422);
    }
}
