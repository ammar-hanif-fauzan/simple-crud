<?php

namespace App\Http\Controllers\Api\Controller;

use App\Http\Controllers\Controller;
use App\Models\Hobby;
use Illuminate\Http\Request;

class HobbyApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/hobbies",
     *     tags={"Hobbies"},
     *     summary="Get list of hobbies",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function index()
    {
        $hobbies = Hobby::paginate(10);
        return response()->json($hobbies);
    }

    /**
     * @OA\Post(
     *     path="/api/hobbies",
     *     tags={"Hobbies"},
     *     summary="Create a new hobby",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Football")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hobby = Hobby::create([
            'name' => $request->name,
        ]);

        return response()->json($hobby, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/hobbies/{id}",
     *     tags={"Hobbies"},
     *     summary="Get a hobby by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(Hobby $hobby)
    {
        return response()->json($hobby);
    }

    /**
     * @OA\Put(
     *     path="/api/hobbies/{id}",
     *     tags={"Hobbies"},
     *     summary="Update a hobby",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Basketball")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(Request $request, Hobby $hobby)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hobby->update([
            'name' => $request->name,
        ]);

        return response()->json($hobby);
    }

    /**
     * @OA\Delete(
     *     path="/api/hobbies/{id}",
     *     tags={"Hobbies"},
     *     summary="Delete a hobby",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroy(Hobby $hobby)
    {
        $hobby->delete();

        return response()->json([
            'message' => 'Hobby deleted successfully.',
            'data' => $hobby
        ]);
    }
}
