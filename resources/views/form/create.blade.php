@extends('layouts.app')

@section('title', 'Create')

@section('body')
        <h1 class="text-2xl font-bold mb-6">Create Input</h1>
            <form class="max-w-sm mx-auto flex flex-col gap-2 mt-4" action="{{ route('form.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col">
                    <label for="text" class="block text-sm font-medium text-gray-900">Text</label>
                    <input type="text" name="text" value="{{ old('text') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="Text">
                </div>
                <div class="flex flex-col">
                    <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="Email">
                </div>
                <div class="flex flex-col">
                    <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    <input type="password" name="password" value="{{ old('password') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="Password">
                </div>
                <div class="flex flex-col">
                    <label for="textarea" class="block text-sm font-medium text-gray-900">Text Area</label>
                    <textarea name="textarea" value="{{ old('textarea') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="Text Area"></textarea>
                </div>
                <div class="flex flex-col">
                    <label for="select" class="block text-sm font-medium text-gray-900">Select</label>
                    <select name="select" value="{{ old('select') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5">
                        <option value="">Select</option>
                        <option value="option 1" old('select') == 'option1' ? 'selected' : ''>Option 1</option>
                        <option value="option 2" old('select') == 'option2' ? 'selected' : ''>Option 2</option>
                        <option value="option 3" old('select') == 'option3' ? 'selected' : ''>Option 3</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <label for="checkbox" class="block text-sm font-medium text-gray-900">Checkbox</label>
                    <div class="flex flex-row gap-4">
                        <div class="flex flex-row gap-2">
                            <input type="checkbox" name="checkbox[]" id="checkbox1" value="1" {{ is_array(old('checkboxes')) && in_array('checkbox1', old('checkboxes')) ? 'checked' : '' }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5">
                            <label for="checkbox1" class="block text-sm font-medium text-gray-900">Checkbox 1</label>
                        </div>
                        <div class="flex flex-row gap-2">
                            <input type="checkbox" name="checkbox[]" id="checkbox2" value="2" {{ is_array(old('checkboxes')) && in_array('checkbox2', old('checkboxes')) ? 'checked' : '' }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5">
                            <label for="checkbox2" class="block text-sm font-medium text-gray-900">Checkbox 2</label>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <label for="radio" class="block text-sm font-medium text-gray-900">radio</label>
                    <div class="flex flex-row gap-4">
                        <div class="flex flex-row gap-2">
                            {{-- <input type="radio" name="radio" id="radio1" value="radio1"{{ old('radio') == 'radio1' ?? 'checked' : '' }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5"> --}}
                            <input type="radio" name="radio" id="radio1" value="Radio 1" {{ old('radio') == 'radio1' ? 'checked' : (old('radio') ? '' : '') }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5">   
                            <label for="radio1" class="block text-sm font-medium text-gray-900">Radio 1</label>
                        </div>
                        <div class="flex flex-row gap-2">
                            <input type="radio" name="radio" id="radio2" value="Radio 2" {{ old('radio') == 'radio2' ? 'checked' : '' }} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5">
                            <label for="radio2" class="block text-sm font-medium text-gray-900">Radio 2</label>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col">
                    <label for="file" class="block text-sm font-medium text-gray-900">File</label>
                    <input type="file" name="file" value="{{ old('file') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="file requiredy">
                </div>
                <div class="flex flex-col">
                    <label for="date" class="block text-sm font-medium text-gray-900">Date</label>
                    <input type="date" name="date" value="{{ old('date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="date">
                </div>
                <div class="flex flex-col">
                    <label for="number" class="block text-sm font-medium text-gray-900">Number</label>
                    <input type="number" name="number" value="{{ old('number') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="number">
                </div>
                <div class="flex flex-col">
                    <label for="range" class="block text-sm font-medium text-gray-900">Range</label>
                    <input type="range" name="range" value="{{ old('range') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="range">
                </div>
                <div class="flex flex-col">
                    <label for="color" class="block text-sm font-medium text-gray-900">color</label>
                    <input type="color" name="color" value="{{ old('color') }}" class="bg-gray-50 border border-gray-300 text-[{{ old('color') }}] text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="color">
                </div>
                <button class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg w-full text-sm px-5 py-2.5 me-2 mb-2">Submit</button>
            </form>
            @if ($errors->any())
            <div class="mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Whoops! Something went wrong.</strong>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

@endsection