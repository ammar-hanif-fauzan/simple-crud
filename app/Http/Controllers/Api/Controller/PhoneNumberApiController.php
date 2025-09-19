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
        $phoneNumbers = PhoneNumber::with('people')->paginate(5);
        return response()->json($phoneNumbers);
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
        $phoneNumber = new PhoneNumber;
        $phoneNumber->people_id = $request->people_id;
        $phoneNumber->phone_number = $request->phone_number;
        $phoneNumber->save();

        $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);
        return response()->json($phoneNumber, 201);
    }

    /**
     * Get a phone number by ID
     * 
     * Mengambil detail nomor telepon berdasarkan ID
     * 
     * @param int id ID nomor telepon
     * @tags Phone Numbers
     */
    public function show(PhoneNumber $phoneNumber)
    {
        $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);
        return response()->json($phoneNumber);
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
        $phoneNumber = PhoneNumber::find($id);
        $phoneNumber->people_id = $request->people_id;
        $phoneNumber->phone_number = $request->phone_number;
        $phoneNumber->save();

        $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);
        return response()->json($phoneNumber, 200);
    }

    /**
     * Delete a phone number
     * 
     * Menghapus nomor telepon
     * 
     * @param int id ID nomor telepon
     * @tags Phone Numbers
     */
    public function destroy(PhoneNumber $phoneNumber)
    {
        $phoneNumber = PhoneNumber::with('people')->find($phoneNumber->id);
        $phoneNumber->delete();

        return response()->json([
            'message' => 'Phone number deleted successfully.',
            'data' => $phoneNumber
        ]);
    }
}