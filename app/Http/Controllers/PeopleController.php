<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use App\Models\IdCard;
use App\Models\Hobby;
use App\Models\PhoneNumber;
use Illuminate\Support\Facades\DB;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = People::with(['idCard', 'hobbies', 'phoneNumbers'])->paginate(5);

        return view('people.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hobbies = Hobby::all();

        return view('people.create', compact('hobbies'));
    }

    /**
     * Store a newly created resource in storage.
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
                'phone_numbers' => 'nullable|array',
                'phone_numbers.*' => 'string|unique:phone_numbers,phone_number'
            ]);

            // Mulai database transaction
            DB::beginTransaction();

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

            // Create phone numbers if provided
            if (!empty($validatedData['phone_numbers'])) {
                foreach ($validatedData['phone_numbers'] as $phoneNumber) {
                    if (!empty($phoneNumber)) {
                        PhoneNumber::create([
                            'people_id' => $people->id,
                            'phone_number' => $phoneNumber
                        ]);
                    }
                }
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('people.index')->with('success', 'People created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to create people: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(People $people)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $person = People::with(['idCard', 'hobbies', 'phoneNumbers'])->find($id);
        
        if (!$person) {
            return redirect()->route('people.index')->with('error', 'People not found.');
        }
        
        $hobbies = Hobby::all();
        
        return view('people.edit', compact('person', 'hobbies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        try {
            $people = People::find($id);
            
            if (!$people) {
                return redirect()->route('people.index')->with('error', 'People not found.');
            }

            // Validasi input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'id_number' => 'required|string|unique:id_cards,id_number,' . $people->idCard->id,
                'hobby_id' => 'required|array|min:1',
                'hobby_id.*' => 'exists:hobbies,id'
            ]);

            // Mulai database transaction
            DB::beginTransaction();

            // Update people
            $people->update([
                'name' => $validatedData['name']
            ]);

            // Update id card
            $people->idCard->update([
                'id_number' => $validatedData['id_number']
            ]);

            // Update hobbies
            $people->hobbies()->sync($validatedData['hobby_id']);

            // Commit transaction
            DB::commit();

            return redirect()->route('people.index')->with('success', 'People updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to update people: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $people = People::find($id);
            
            if (!$people) {
                return redirect()->route('people.index')->with('error', 'People not found.');
            }

            // Mulai database transaction
            DB::beginTransaction();

            // Delete people (cascade akan menghapus relasi)
            $people->delete();

            // Commit transaction
            DB::commit();

            return redirect()->route('people.index')->with('success', 'People deleted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('people.index')->with('error', 'Failed to delete people: ' . $e->getMessage());
        }
    }
}
