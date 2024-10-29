<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateFormInputRequest;
use App\Models\FormInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;         

class FormInputApiController extends Controller
{
    public function index()
    {
        dd('a');
        $inputs = FormInput::paginate(5);

        return response()->json($inputs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'checkbox' => 'nullable|array',
            'checkbox.*' => 'nullable|string',
            'radio' => 'required|string|max:255',
            'select' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'textarea' => 'required|string',
            'date' => 'required|date',
            'number' => 'required|integer',
            'range' => 'required|integer',
            'color' => 'required|string|max:7',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('uploads', 'public');
        }

        $checkboxes = $request->checkbox ? json_encode($request->checkbox) : null;

        FormInput::create([
            'text' => $request->text,
            'email' => $request->email,
            'password' =>$request->password,
            'checkbox' => $checkboxes,
            'radio' => $request->radio,
            'select' => $request->select,
            'file' => $filePath,
            'textarea' => $request->textarea,
            'date' => $request->date,
            'number' => $request->number,
            'range' => $request->range,
            'color' => $request->color,
        ]);

        return response()->json(['message' => 'Input created successfully']);
    }

    public function show(FormInput $input)
    {
        return response()->json($input);
    }

    public function update(UpdateFormInputRequest $request, $id)
    {
        $input = FormInput::find($id);

        $checkboxes = $request->checkbox ? json_encode($request->checkbox) : null;

        $input->fill([
            'text' => $request->text,
            'email' => $request->email,
            'password' => $request->password,
            'checkbox' => $checkboxes,
            'radio' => $request->radio,
            'select' => $request->select,
            'file' => $request->hasFile('file') ? $request->file('file')->store('uploads', 'public') : $input->file,
            'textarea' => $request->textarea,
            'date' => $request->date,
            'number' => $request->number,
            'range' => $request->range,
            'color' => $request->color,
        ]);

        $input->save();

        return response()->json(['message' => 'Input updated successfully']);
    }


    public function destroy($id)
    {
        $input = FormInput::find($id);
        $input->delete();

        return response()->json(['message' => 'Input deleted successfully']);
    }
}
