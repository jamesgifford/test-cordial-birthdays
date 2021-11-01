<?php

use App\Models\Person;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GetPeopleTest extends TestCase
{
    /**
     * Get all people in the database.
     *
     * @return void
     */
    public function testGetAllPeople()
    {
        $response = $this->call('GET', 'http://localhost:8000/api/people',
            [], ['Content-Type' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    'name',
                    'birthdate',
                    'timezone',
                    'interval' => [
                        'y', 'm', 'd', 'h', 'i', 's'
                    ],
                    'isBirthday',
                    'age',
                    'message'
                ]
            ]);
    }

    /**
     * Get all people in the database using a valid date for the interval.
     *
     * @return void
     */
    public function testGetAllPeopleUsingValidDate()
    {
        $data = [
            'date' => '2031-01-01'
        ];

        $response = $this->call('GET', 'http://localhost:8000/api/people',
            $data, ['Content-Type' => 'application/json']);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    'name',
                    'birthdate',
                    'timezone',
                    'interval' => [
                        'y', 'm', 'd', 'h', 'i', 's'
                    ],
                    'isBirthday',
                    'age',
                    'message'
                ]
            ]);
    }

    /**
     * Get all people in the database using an invalid date for the interval.
     *
     * @return void
     */
    public function testGetAllPeopleUsingInvalidDate()
    {
        $data = [
            'date' => 'not a date'
        ];

        $response = $this->call('GET', 'http://localhost:8000/api/people',
            $data, ['Content-Type' => 'application/json']);

        $response->assertStatus(422);
    }
}
