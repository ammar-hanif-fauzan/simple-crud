<?php

namespace App\Http\Controllers\Api;

use App\Models\Hobby;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HobbyApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hobbies = Hobby::paginate(10);

        return response()->json($hobbies);
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

        return response()->json($hobby);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hobby $hobby)
    {
        return response()->json($hobby);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hobby $hobby)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hobby->name = $request->name;
        $hobby->save();

        return response()->json($hobby);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hobby $hobby)
    {
        $hobby = Hobby::find($hobby->id);
        $hobby->delete();

        return response()->json([
            'message' => 'Hobby deleted successfully.',
            'data' => $hobby
        ]);
    }
}