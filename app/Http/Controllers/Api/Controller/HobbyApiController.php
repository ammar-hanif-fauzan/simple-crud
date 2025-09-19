<?php

namespace App\Http\Controllers\Api\Controller;

use App\Http\Controllers\Controller;
use App\Models\Hobby;
use Illuminate\Http\Request;

class HobbyApiController extends Controller
{
    /**
     * Get list of hobbies
     * 
     * Mengambil daftar semua hobby
     * @tags Hobbies
         */
    public function index()
    {
        try {
            $hobbies = Hobby::with('people')->paginate(10);
            
            return response()->json([
                'success' => true,
                'message' => 'Hobbies retrieved successfully',
                'data' => $hobbies
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
     * Create a new hobby
     * 
     * Membuat hobby baru
     * 
     * @param string name Nama hobby
     * @tags Hobbies
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:hobbies,name',
            ]);

            $hobby = Hobby::create([
                'name' => $validatedData['name'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hobby created successfully',
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
                'message' => 'Failed to create hobby',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a hobby by ID
     * 
     * Mengambil detail hobby berdasarkan ID
     * 
     * @param int id ID hobby
     * @tags Hobbies
     */
    public function show($id)
    {
        try {
            $hobby = Hobby::with('people')->find($id);
            
            if (!$hobby) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hobby not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Hobby retrieved successfully',
                'data' => $hobby
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve hobby',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a hobby
     * 
     * Mengupdate hobby
     * 
     * @param int id ID hobby
     * @param string name Nama hobby
     * @tags Hobbies
     */
    public function update(Request $request, $id)
    {
        try {
            $hobby = Hobby::find($id);
            
            if (!$hobby) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hobby not found'
                ], 404);
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:hobbies,name,' . $id,
            ]);

            $hobby->update([
                'name' => $validatedData['name'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hobby updated successfully',
                'data' => $hobby
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update hobby',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a hobby
     * 
     * Menghapus hobby
     * 
     * @param int id ID hobby
     * @tags Hobbies
     */
    public function destroy($id)
    {
        try {
            $hobby = Hobby::find($id);
            
            if (!$hobby) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hobby not found'
                ], 404);
            }

            // Check if hobby is being used by people
            if ($hobby->people()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete hobby. It is being used by ' . $hobby->people()->count() . ' person(s)'
                ], 409);
            }

            $hobby->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hobby deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete hobby',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}