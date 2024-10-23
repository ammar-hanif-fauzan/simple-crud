<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\IdCard;
use App\Models\Hobby;

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
        $hobbies = Hobby::all();

        return view('people.create', compact('hobbies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $people = new People;
        $people->name = $request->name;
        $people->save();

        // One to One - Create IdCard
        $idCard = new IdCard;
        $idCard->people_id = $people->id;
        $idCard->id_number = $request->id_number;
        $idCard->save();
        
        // Many to Many - Attach Hobby
        $people->hobbies()->attach($request->hobby_id);

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
        $hobbies = Hobby::all();
        
        return view('people.edit', compact('person', 'hobbies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $people = People::find($id);
        $people->name = $request->name;
        $people->update();

        // One to One - Update IdCard
        $idCard = IdCard::where('people_id', $people->id)->first();
        $idCard->id_number = $request->id_number;
        $idCard->update();
        
        // Many to Many - Sync Hobby
        $people->hobbies()->sync($request->hobby_id);

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
