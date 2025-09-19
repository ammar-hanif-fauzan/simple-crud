<?php

namespace App\Http\Controllers\Api\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhoneNumber;

class PhoneNumberApiController extends Controller
{
    /**
     * Get list of phone numbers
     * 
     * Mengambil daftar semua nomor telepon dengan relasi people
     * @tags Phone Numbers
     * @OA\Get(
     *   path="/api/v1/phone-number",
     *   summary="Get all phone numbers",
     *   description="Mengambil daftar semua nomor telepon dengan relasi people",
     *   tags={"Phone Numbers"},
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="current_page", type="integer"),
     *       @OA\Property(property="data", type="array",
     *         @OA\Items(
     *           @OA\Property(property="id", type="integer"),
     *           @OA\Property(property="phone_number", type="string"),
     *           @OA\Property(property="people_id", type="integer"),
     *           @OA\Property(property="created_at", type="string", format="datetime"),
     *           @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *       )
     *     )
     *   )
     * )
     */
    public function index()
    {
        try {
            $phoneNumbers = PhoneNumber::with('people')->paginate(5);
            
            return response()->json([
                'success' => true,
                'message' => 'Phone numbers retrieved successfully',
                'data' => $phoneNumbers
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
     * Create a new phone number
     * 
     * Membuat nomor telepon baru
     * 
     * @param int people_id ID orang
     * @param string phone_number Nomor telepon
     * @tags Phone Numbers
     * @OA\Post(
     *   path="/api/v1/phone-number",
     *   summary="Create new phone number",
     *   description="Membuat nomor telepon baru",
     *   tags={"Phone Numbers"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="people_id", type="integer", example=1),
     *       @OA\Property(property="phone_number", type="string", example="081234567890")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Phone number created successfully",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Phone number created successfully"),
     *       @OA\Property(property="data", type="object")
     *     )
     *   )
     * )
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'people_id' => 'required|exists:people,id',
                'phone_number' => 'required|string|unique:phone_numbers,phone_number|regex:/^[0-9+\-\s()]+$/'
            ]);

            $phoneNumber = PhoneNumber::create([
                'people_id' => $validatedData['people_id'],
                'phone_number' => $validatedData['phone_number']
            ]);

            $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);

            return response()->json([
                'success' => true,
                'message' => 'Phone number created successfully',
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
                'message' => 'Failed to create phone number',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a phone number by ID
     * 
     * Mengambil detail nomor telepon berdasarkan ID
     * 
     * @param int id ID nomor telepon
     * @tags Phone Numbers
     */
    public function show($id)
    {
        try {
            $phoneNumber = PhoneNumber::with('people')->find($id);
            
            if (!$phoneNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Phone number retrieved successfully',
                'data' => $phoneNumber
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve phone number',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a phone number
     * 
     * Mengupdate nomor telepon
     * 
     * @param int id ID nomor telepon
     * @param int people_id ID orang
     * @param string phone_number Nomor telepon
     * @tags Phone Numbers
     */
    public function update(Request $request, $id)
    {
        try {
            $phoneNumber = PhoneNumber::find($id);
            
            if (!$phoneNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number not found'
                ], 404);
            }

            $validatedData = $request->validate([
                'people_id' => 'required|exists:people,id',
                'phone_number' => 'required|string|unique:phone_numbers,phone_number,' . $id . '|regex:/^[0-9+\-\s()]+$/'
            ]);

            $phoneNumber->update([
                'people_id' => $validatedData['people_id'],
                'phone_number' => $validatedData['phone_number']
            ]);

            $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);

            return response()->json([
                'success' => true,
                'message' => 'Phone number updated successfully',
                'data' => $phoneNumber
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
                'message' => 'Failed to update phone number',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a phone number
     * 
     * Menghapus nomor telepon
     * 
     * @param int id ID nomor telepon
     * @tags Phone Numbers
     */
    public function destroy($id)
    {
        try {
            $phoneNumber = PhoneNumber::find($id);
            
            if (!$phoneNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number not found'
                ], 404);
            }

            $phoneNumber->delete();

            return response()->json([
                'success' => true,
                'message' => 'Phone number deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete phone number',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}