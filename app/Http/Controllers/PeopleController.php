<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\IdCard;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = People::paginate(5);

        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $people = new People;
        $people->name = $request->name;
        $people->save();

        $idCard = new IdCard;
        $idCard->people_id = $people->id;
        $idCard->id_number = $request->id_number;
        $idCard->save();

        return redirect()->route('people.index')->with('success', 'People created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(People $people)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $person = People::find($id);
        
        return view('people.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $people = People::find($id);
        $people->name = $request->name;
        $people->update();

        $idCard = IdCard::where('people_id', $people->id)->first();
        $idCard->id_number = $request->id_number;
        $idCard->update();

        return redirect()->route('people.index')->with('success', 'People updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $people = People::find($id);
        $people->delete();

        return redirect()->route('people.index')->with('success', 'People deleted successfully.');
    }
}
