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
     * @var \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
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
     * Get a single person
     *
     * @var \Illuminate\Http\Request
     * @var \App\Models\Person
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Person $person)
    {
        $validated = $this->validate($request, [
            'date' => 'nullable|date',
        ]);

        if ($request->date) {
            $date = Carbon::parse($validated['date']);

            $person->interval = $date;
            $person->save();
        }

        return response()->json($person);
    }

    /**
     * Add a new person record to the database.
     *
     * @var \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * Delete a single person record from the database.
     *
     * @var \App\Models\Person
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy (Person $person)
    {
        $person->delete();

        return response()->json(null, 204);
    }
}
