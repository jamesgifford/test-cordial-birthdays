<?php

use App\Models\Person;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PersonTest extends TestCase
{
    /**
     * Test that a person has the expected data.
     *
     * @return void
     */
    public function testPerson()
    {
        $person = Person::factory()->make([
            'name' => 'John Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ]);

        $this->assertEquals($person->name, 'John Smith');
        $this->assertEquals($person->birthdate, '1970-01-01');
        $this->assertEquals($person->timezone, 'America/Los_Angeles');
    }

    /**
     * Test that the interval uses the current date by default.
     *
     * @return void
     */
    public function testPersonIntervalFromNow()
    {
        $person = Person::factory()->make([
            'name' => 'John Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ]);

        $today = Carbon::now()->timezone($person->timezone);
        $birthday = Carbon::parse($person->birthdate);
        $birthday->year($today->year);
        if ($today->diffInDays($birthday, false) <= 0) {
            $birthday->addYear();
        }
        $diff = $birthday->diff($today);

        $this->assertIsArray($person->interval);
        $this->assertEquals($person->interval['y'], $diff->y);
        $this->assertEquals($person->interval['m'], $diff->m);
        $this->assertEquals($person->interval['d'], $diff->d);
    }

    /**
     * Test that the interval is correct with a specified date.
     *
     * @return void
     */
    public function testPersonIntervalFromDate()
    {
        $person = Person::factory()->make([
            'name' => 'John Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ]);
        $date = Carbon::parse('2100-01-01');
        $person->interval = $date;

        $today = Carbon::now()->timezone($person->timezone);
        $birthday = Carbon::parse($person->birthdate);
        $birthday->year($date->year);
        if ($date->diffInDays($birthday, false) <= 0) {
            $birthday->addYear();
        }
        $diff = $birthday->diff($today);

        $this->assertIsArray($person->interval);
        $this->assertEquals($person->interval['y'], $diff->y);
        $this->assertEquals($person->interval['m'], $diff->m);
        $this->assertEquals($person->interval['d'], $diff->d);
    }

    /**
     * Test that a person's birthdate message is as expected.
     *
     * @return void
     */
    public function testPersonMessage()
    {
        $person = Person::factory()->make([
            'name' => 'John Smith',
            'birthdate' => '1970-01-01',
            'timezone' => 'America/Los_Angeles',
        ]);

        $this->assertStringContainsString(sprintf('%s will',
            $person->name), $person->message);
        $this->assertStringContainsString(sprintf('turn %d years',
            $person->age + $person->interval['y'] + 1), $person->message);
        $this->assertStringContainsString(sprintf('%d days',
            $person->interval['d']), $person->message);

        if ((int)$person->interval['y']) {
            $this->assertStringContainsString(sprintf('%d years,',
                $person->interval['y']), $person->message);
        }

        if ((int)$person->interval['m']) {
            $this->assertStringContainsString(sprintf('%d months,',
                $person->interval['m']), $person->message);
        }
    }
}
