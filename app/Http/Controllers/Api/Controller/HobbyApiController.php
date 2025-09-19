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
        $hobbies = Hobby::paginate(10);
        return response()->json($hobbies);
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hobby = Hobby::create([
            'name' => $request->name,
        ]);

        return response()->json($hobby, 201);
    }

    /**
     * Get a hobby by ID
     * 
     * Mengambil detail hobby berdasarkan ID
     * 
     * @param int id ID hobby
     * @tags Hobbies
     */
    public function show(Hobby $hobby)
    {
        return response()->json($hobby);
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
     * Delete a hobby
     * 
     * Menghapus hobby
     * 
     * @param int id ID hobby
     * @tags Hobbies
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