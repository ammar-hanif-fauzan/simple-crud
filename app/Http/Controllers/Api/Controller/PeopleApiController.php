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

    /**
     * Get all phone numbers for a person
     * 
     * Mengambil semua nomor telepon milik seseorang
     * 
     * @param int id ID orang
     * @tags People
     */
    public function getPhoneNumbers($id)
    {
        try {
            $person = People::find($id);
            
            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            $phoneNumbers = $person->phoneNumbers;

            return response()->json([
                'success' => true,
                'message' => 'Phone numbers retrieved successfully',
                'data' => [
                    'person' => $person,
                    'phone_numbers' => $phoneNumbers
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve phone numbers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add phone number to a person
     * 
     * Menambah nomor telepon untuk seseorang
     * 
     * @param int id ID orang
     * @param string phone_number Nomor telepon
     * @tags People
     */
    public function addPhoneNumber(Request $request, $id)
    {
        try {
            $person = People::find($id);
            
            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            $validatedData = $request->validate([
                'phone_number' => 'required|string|unique:phone_numbers,phone_number|regex:/^[0-9+\-\s()]+$/'
            ]);

            $phoneNumber = PhoneNumber::create([
                'people_id' => $person->id,
                'phone_number' => $validatedData['phone_number']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Phone number added successfully',
                'data' => $phoneNumber
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add phone number',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove phone number from a person
     * 
     * Menghapus nomor telepon dari seseorang
     * 
     * @param int id ID orang
     * @param int phone_id ID nomor telepon
     * @tags People
     */
    public function removePhoneNumber($id, $phone_id)
    {
        try {
            $person = People::find($id);
            
            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            $phoneNumber = PhoneNumber::where('id', $phone_id)
                                    ->where('people_id', $person->id)
                                    ->first();

            if (!$phoneNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number not found for this person'
                ], 404);
            }

            $phoneNumber->delete();

            return response()->json([
                'success' => true,
                'message' => 'Phone number removed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove phone number',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all hobbies for a person
     * 
     * Mengambil semua hobby milik seseorang
     * 
     * @param int id ID orang
     * @tags People
     */
    public function getHobbies($id)
    {
        try {
            $person = People::find($id);
            
            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            $hobbies = $person->hobbies;

            return response()->json([
                'success' => true,
                'message' => 'Hobbies retrieved successfully',
                'data' => [
                    'person' => $person,
                    'hobbies' => $hobbies
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve hobbies',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add hobby to a person
     * 
     * Menambah hobby untuk seseorang
     * 
     * @param int id ID orang
     * @param int hobby_id ID hobby
     * @tags People
     */
    public function addHobby(Request $request, $id)
    {
        try {
            $person = People::find($id);
            
            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            $validatedData = $request->validate([
                'hobby_id' => 'required|exists:hobbies,id'
            ]);

            // Check if hobby already exists
            if ($person->hobbies()->where('hobby_id', $validatedData['hobby_id'])->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hobby already exists for this person'
                ], 409);
            }

            $person->hobbies()->attach($validatedData['hobby_id']);

            $hobby = Hobby::find($validatedData['hobby_id']);

            return response()->json([
                'success' => true,
                'message' => 'Hobby added successfully',
                'data' => $hobby
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add hobby',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove hobby from a person
     * 
     * Menghapus hobby dari seseorang
     * 
     * @param int id ID orang
     * @param int hobby_id ID hobby
     * @tags People
     */
    public function removeHobby($id, $hobby_id)
    {
        try {
            $person = People::find($id);
            
            if (!$person) {
                return response()->json([
                    'success' => false,
                    'message' => 'Person not found'
                ], 404);
            }

            // Check if hobby exists for this person
            if (!$person->hobbies()->where('hobby_id', $hobby_id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hobby not found for this person'
                ], 404);
            }

            $person->hobbies()->detach($hobby_id);

            return response()->json([
                'success' => true,
                'message' => 'Hobby removed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove hobby',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
