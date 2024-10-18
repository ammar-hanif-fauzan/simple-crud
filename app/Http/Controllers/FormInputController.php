<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateFormInputRequest;
use App\Models\FormInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FormInputController extends Controller
{
    public function index()
    {
        $inputs = FormInput::simplePaginate(5);
        return view('form.index', compact('inputs'));
    }

    public function create()
    {
        return view('form.create');
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

        return redirect()->route('form.index')->with('success', 'Input created successfully');
    }

    public function show(FormInput $input)
    {
        // Ambil halaman terakhir yang dikunjungi oleh pengguna dari session
        $lastPage = Session::get('lastPage');

        // Hapus halaman terakhir yang dikunjungi dari session
        Session::forget('lastPage');

        // Jika halaman terakhir yang dikunjungi ada, arahkan pengguna ke halaman tersebut
        if ($lastPage) {
            return redirect($lastPage);
        }

        // Jika halaman terakhir yang dikunjungi tidak ada, arahkan pengguna ke halaman default
        return redirect()->route('form.index');
    }

    public function edit($id)
    {
        $input = FormInput::find($id);
        return view('form.edit', compact('input'));
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

        return redirect()->route('form.index')->with('success', 'Input updated successfully');
    }


    public function destroy($id)
    {
        $input = FormInput::find($id);
        $input->delete();
        return redirect()->route('form.index')->with('success', 'Input deleted successfully');
    }
}
