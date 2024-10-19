<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $phoneNumbers = PhoneNumber::paginate(5);

        return view('phone-number.index', compact('phoneNumbers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $people = People::all();

        return view('phone-number.create', compact('people'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'people_id' => 'required',
            'phone_number' => 'required',
        ]);

        $phoneNumber = new PhoneNumber;
        $phoneNumber->people_id = $request->people_id;
        $phoneNumber->phone_number = $request->phone_number;
        $phoneNumber->save();

        return redirect()->route('phone-number.index')->with('success', 'Phone number created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhoneNumber $phoneNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhoneNumber $phoneNumber)
    {
        $people = People::all();

        return view('phone-number.edit', compact('phoneNumber', 'people'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhoneNumber $phoneNumber)
    {
        $request->validate([
            'people_id' => 'required',
            'phone_number' => 'required',
        ]);

        $phoneNumber->people_id = $request->people_id;
        $phoneNumber->phone_number = $request->phone_number;
        $phoneNumber->save();

        return redirect()->route('phone-number.index')->with('success', 'Phone number updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhoneNumber $phoneNumber)
    {
        $phoneNumber->delete();

        return redirect()->route('phone-number.index')->with('success', 'Phone number deleted successfully.');
    }
}
