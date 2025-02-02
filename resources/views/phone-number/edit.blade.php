@extends('layouts.app')

@section('title', 'Edit')

@section('body')
    <h1 class="text-2xl font-bold mb-6">Edit Phone Number</h1>
    @if (session('success'))
        <div class="mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    <form class="max-w-sm mx-auto flex flex-col gap-2 mt-4" action="{{ route('phone-number.update', $phoneNumber->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="flex flex-col">
            <label for="text" class="block text-sm font-medium text-gray-900">Name</label>
            <select name="people_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5">
                <option value="">Select Name</option>
                @foreach($people as $person)
                    <option value="{{ $person->id }}" {{ $person->id == $phoneNumber->people_id ? 'selected' : '' }}>{{ $person->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <label for="number" class="block text-sm font-medium text-gray-900">Phone Number</label>
            <input type="number" name="phone_number" value="{{ old('phone_number', $phoneNumber->phone_number) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="Number">
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
