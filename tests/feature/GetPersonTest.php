<?php

use App\Models\Person;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GetPersonTest extends TestCase
{
    /**
     * Get one person record from the database.
     *
     * @return void
     */
    public function testGetPerson()
    {
        $person = Person::create([
            'name' => 'John Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ]);

        $response = $this->call('GET', 'http://localhost:8000/api/person/'.$person->_id,
            [], ['Content-Type' => 'application/json']);

        $response
            ->assertStatus(200)
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
            ]);
    }

    /**
     * Get one person in the database using a valid date for the interval.
     *
     * @return void
     */
    public function testGetPersonUsingValidDate()
    {
        $person = Person::create([
            'name' => 'John Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ]);

        $data = [
            'date' => '2031-01-01'
        ];

        $response = $this->call('GET', 'http://localhost:8000/api/person/'.$person->_id,
            $data, ['Content-Type' => 'application/json']);

        $response
            ->assertStatus(200)
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
            ]);
    }

    /**
     * Get a person in the database using an invalid date for the interval.
     *
     * @return void
     */
    public function testGetPersonUsingInvalidDate()
    {
        $person = Person::create([
            'name' => 'John Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ]);

        $data = [
            'date' => 'not a date'
        ];

        $response = $this->call('GET', 'http://localhost:8000/api/person/'.$person->_id,
            $data, ['Content-Type' => 'application/json']);

        $response->assertStatus(422);
    }
}
