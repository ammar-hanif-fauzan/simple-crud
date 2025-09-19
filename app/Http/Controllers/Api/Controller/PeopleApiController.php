<?php

namespace App\Http\Controllers\Api\Controller;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\IdCard;
use App\Models\Hobby;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class PeopleApiController extends Controller
{
    /**
     * Get list of people
     * 
     * Mengambil daftar semua orang dengan relasi idCard, hobbies, dan phoneNumber
     * @tags People
     */
    public function index()
    {
        $people = People::with(['idCard', 'hobbies', 'PhoneNumber'])->paginate(5);

        return response()->json($people);
    }

    /**
     * Create a new person
     * 
     * Membuat orang baru dengan idCard dan hobby
     * 
     * @param string name Nama orang
     * @param string id_number Nomor identitas
     * @param array hobby_id Array ID hobby
     * @tags People
     */
    public function store(Request $request)
    {
        // Validasi input (opsional)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required',
            'hobby_id' => 'required',
        ]);

        $people = new People;
        $people->name = $request->name;
        $people->save();

        $idCard = new IdCard;
        $idCard->people_id = $people->id;
        $idCard->id_number = $request->id_number;
        $idCard->save();

        $people->hobbies()->attach($request->hobby_id);

        $person = People::with('idCard', 'hobbies')->find($people->id);
        return response()->json([
            'message' => 'People created successfully.',
            'data' => $person
        ]);
    }

    /**
     * Get a person by ID
     * 
     * Mengambil detail orang berdasarkan ID
     * 
     * @param int id ID orang
     * @tags People
     */
    public function show($id)
    {
        $person = People::with('idCard', 'hobbies')->find($id);

        return response()->json($person);
    }

    /**
     * Update a person
     * 
     * Mengupdate data orang, idCard, dan hobby
     * 
     * @param int id ID orang
     * @param string name Nama orang
     * @param string id_number Nomor identitas
     * @param array hobby_id Array ID hobby
     * @tags People
     */
    public function update(Request $request, $id)
    {
        // Cari data people berdasarkan id
        $people = People::with(['idCard', 'hobbies'])->find($id);
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

        // Update hobbies
        $people->hobbies()->sync($request->hobby_id);

        $people = People::with(['idCard', 'hobbies'])->find($id);
        // Response JSON sukses
        return response()->json([
            'message' => 'People updated successfully.',
            'data' => $people
        ]);
    }

    /**
     * Delete a person
     * 
     * Menghapus orang dan semua relasinya
     * 
     * @param int id ID orang
     * @tags People
     */
    public function destroy($id)
    {
        $people = People::with('idCard', 'hobbies')->find($id);
        $people->delete();

        return response()->json([
            'message' => 'People deleted successfully.',
            'data' => $people
        ]);
    }
}
