<?php

namespace App\Http\Controllers;

use App\Models\Hobby;
use Illuminate\Http\Request;

class HobbyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hobbies = Hobby::paginate(10);

        return view('hobby.index', compact('hobbies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hobby.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hobby = new Hobby();
        $hobby->name = $request->name;
        $hobby->save();

        return redirect()->route('hobbies.index')->with('success', 'Hobby created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hobby $hobby)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hobby $hobby)
    {
        $hobby = Hobby::find($hobby->id);

        return view('hobby.edit', compact('hobby'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hobby $hobby)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hobby = Hobby::find($hobby->id);
        $hobby->name = $request->name;
        $hobby->save();

        return redirect()->route('hobbies.index')->with('success', 'Hobby updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hobby $hobby)
    {
        $hobby = Hobby::find($hobby->id);
        $hobby->delete();

        return redirect()->route('hobbies.index')->with('success', 'Hobby deleted successfully.');
    }
}
