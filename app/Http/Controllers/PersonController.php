<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use App\Models\PersonAddress;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonController extends Controller
{
    public function store(StorePersonRequest $request)
    {
        $person = Person::create($request->validated());

        $address = [
            'person_id' => $person->id,
            'type' => $request->input('type'),
            'zip_code' => $request->input('zip_code'),
            'street' => $request->input('street'),
            'number' => $request->input('number'),
            'complement' => $request->input('complement'),
            'neighborhood' => $request->input('neighborhood'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
        ];

        PersonAddress::create($address);

        return to_route('/');
    }

    public function show(string $personPublicId)
    {
        $person = Person::query()->where('public_id', $personPublicId)->with('addresses')->first();

        if (!$person) {
            return to_route('/');
        }

        return Inertia::render('People/Show', [
            'person' => $person,
        ]);
    }

    public function update(UpdatePersonRequest $request, string $personPublicId)
    {
        $person = Person::query()->where('public_id', $personPublicId)->first();

        if (!$person) {
            return to_route('/');
        }

        $person->update($request->validated());

        return to_route('people.show', [
            'personPublicId' => $person->public_id,
        ]);
    }
}
