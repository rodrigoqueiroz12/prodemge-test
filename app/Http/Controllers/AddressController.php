<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAddressRequest;
use App\Models\PersonAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function update(UpdateAddressRequest $request, PersonAddress $address)
    {
        PersonAddress::create([
            'person_id' => $address->person_id,
            ...$request->validated(),
        ]);

        return to_route('people.show', $address->person->public_id);
    }
}
