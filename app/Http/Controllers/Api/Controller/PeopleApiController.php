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
        $people = People::with(['idCard', 'hobbies', 'phoneNumbers'])->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'People retrieved successfully',
            'data' => $people
        ]);
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
        try {
            // Validasi input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'id_number' => 'required|string|unique:id_cards,id_number',
                'hobby_id' => 'required|array|min:1',
                'hobby_id.*' => 'exists:hobbies,id',
                'phone_number' => 'nullable|string|unique:phone_numbers,phone_number'
            ]);

            // Mulai database transaction
            \DB::beginTransaction();

            // Create people
            $people = People::create([
                'name' => $validatedData['name']
            ]);

            // Create id card
            $idCard = IdCard::create([
                'people_id' => $people->id,
                'id_number' => $validatedData['id_number']
            ]);

            // Attach hobbies
            $people->hobbies()->attach($validatedData['hobby_id']);

            // Create phone number if provided
            if (!empty($validatedData['phone_number'])) {
                PhoneNumber::create([
                    'people_id' => $people->id,
                    'phone_number' => $validatedData['phone_number']
                ]);
            }

            // Commit transaction
            \DB::commit();

            // Load relationships
            $person = People::with(['idCard', 'hobbies', 'phoneNumbers'])->find($people->id);

            return response()->json([
                'success' => true,
                'message' => 'Person created successfully',
                'data' => $person
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create person',
                'error' => $e->getMessage()
            ], 500);
        }
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
        try {
            $person = People::with(['idCard', 'hobbies', 'phoneNumbers'])->find($id);

            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Person retrieved successfully',
                'data' => $person
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve person',
                'error' => $e->getMessage()
            ], 500);
        }
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
        try {
            // Cari data people berdasarkan id
            $people = People::find($id);
            if (!$people) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            // Validasi input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'id_number' => 'required|string|unique:id_cards,id_number,' . $people->idCard->id,
                'hobby_id' => 'required|array|min:1',
                'hobby_id.*' => 'exists:hobbies,id'
            ]);

            // Mulai database transaction
            \DB::beginTransaction();

            // Update people
            $people->update([
                'name' => $validatedData['name']
            ]);

            // Update idCard
            $people->idCard->update([
                'id_number' => $validatedData['id_number']
            ]);

            // Update hobbies
            $people->hobbies()->sync($validatedData['hobby_id']);

            // Commit transaction
            \DB::commit();

            // Load relationships
            $updatedPerson = People::with(['idCard', 'hobbies', 'phoneNumbers'])->find($id);

            return response()->json([
                'success' => true,
                'message' => 'Person updated successfully',
                'data' => $updatedPerson
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update person',
                'error' => $e->getMessage()
            ], 500);
        }
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
        try {
            $people = People::find($id);
            
            if (!$people) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            // Mulai database transaction
            \DB::beginTransaction();

            // Delete people (cascade akan menghapus relasi)
            $people->delete();

            // Commit transaction
            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Person deleted successfully'
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete person',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
