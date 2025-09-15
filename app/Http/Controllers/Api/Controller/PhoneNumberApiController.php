<?php

namespace App\Http\Controllers\Api\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneNumber;

class PhoneNumberApiController extends Controller
{
    /**
     * Display a listing of the phone numbers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phoneNumbers = PhoneNumber::with('people')->paginate(5);
        return response()->json($phoneNumbers);
    }

    /**
     * Store a newly created phone number in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $phoneNumber = new PhoneNumber;
        $phoneNumber->people_id = $request->people_id;
        $phoneNumber->phone_number = $request->phone_number;
        $phoneNumber->save();

        $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);
        return response()->json($phoneNumber, 201);
    }

    /**
     * Display the specified phone number.
     *
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return \Illuminate\Http\Response
     */
    public function show(PhoneNumber $phoneNumber)
    {
        $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);
        return response()->json($phoneNumber);
    }

    /**
     * Update the specified phone number in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $phoneNumber = PhoneNumber::find($id);
        $phoneNumber->people_id = $request->people_id;
        $phoneNumber->phone_number = $request->phone_number;
        $phoneNumber->save();

        $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);
        return response()->json($phoneNumber, 200);
    }

    /**
     * Remove the specified phone number from storage.
     *
     * @param  \App\Models\PhoneNumber  $phoneNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhoneNumber $phoneNumber)
    {
        $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);
        $phoneNumber->delete();

        return response()->json([
            'message' => 'Phone number deleted successfully.',
            'data' => $phoneNumber
        ]);
    }
}
