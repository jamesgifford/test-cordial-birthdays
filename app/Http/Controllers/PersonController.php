<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * List all people in the database.
     *
     * @var Request the HTTP request
     * @return void
     */
    public function index(Request $request)
    {
        $validated = $this->validate($request, [
            'date' => 'nullable|date',
        ]);

        $people = Person::all();

        if ($request->date) {
            $date = Carbon::parse($validated['date']);

            $people->each(function($person, $index) use ($date) {
                $person->interval = $date;
            });
        }

        return response()->json($people);
    }

    /**
     * Add a new person record to the database.
     *
     * @var Request the HTTP request
     * @return void
     */
    public function create(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required|max:255',
            'birthdate' => 'required|date',
            'timezone' => 'required|timezone',
        ]);

        $person = Person::create($request->all());

        return response()->json($person, 201);
    }
}
