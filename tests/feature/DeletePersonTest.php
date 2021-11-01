<?php

use App\Models\Person;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DeletePersonTest extends TestCase
{
    /**
     * Delete one person record from the database.
     *
     * @return void
     */
    public function testDeletePerson()
    {
        $person = Person::firstOrCreate([
            'name' => 'John Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ]);

        $this->seeInDatabase('people', [
            '_id' => $person->_id,
        ]);

        $response = $this->call('DELETE', 'http://localhost:8000/api/person/'.$person->_id,
            [], ['Content-Type' => 'application/json']);

        $response->assertStatus(204);

        $this->notSeeInDatabase('people', [
            '_id' => $person->_id,
        ]);
    }
}
