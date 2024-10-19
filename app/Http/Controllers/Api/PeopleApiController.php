<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\IdCard;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class PeopleApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = People::paginate(5);

        return response()->json($people);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input (opsional)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required',
        ]);

        $people = new People;
        $people->name = $request->name;
        $people->save();

        $idCard = new IdCard;
        $idCard->people_id = $people->id;
        $idCard->id_number = $request->id_number;
        $idCard->save();

        $person = People::with('idCard')->find($people->id);
        return response()->json([
            'message' => 'People created successfully.',
            'data' => $person
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $person = People::with('idCard')->find($id);

        return response()->json($person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari data people berdasarkan id
        $people = People::with('idCard')->find($id);
        if (!$people) {
            return response()->json(['message' => 'People not found.'], 404);
        }

        // Update data people
        $people->name = $request->name;
        $people->save();

        // Update idCard
        $idCard = IdCard::where('people_id', $people->id)->first();
        if ($idCard) {
            $idCard->id_number = $request->id_number;
            $idCard->save();
        }

        // Response JSON sukses
        return response()->json([
            'message' => 'People updated successfully.',
            'data' => $people
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $people = People::with('idCard')->find($id);
        $people->delete();

        return response()->json([
            'message' => 'People deleted successfully.',
            'data' => $people
        ]);
    }
}
