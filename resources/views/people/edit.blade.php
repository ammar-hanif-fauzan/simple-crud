@extends('layouts.app')

@section('title', 'Edit')

@section('body')
    <h1 class="text-2xl font-bold mb-6">Edit People</h1>
    @if (session('success'))
        <div class="mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    <form class="max-w-sm mx-auto flex flex-col gap-2 mt-4" action="{{ route('people.update', $person->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="flex flex-col">
            <label for="text" class="block text-sm font-medium text-gray-900">Name</label>
            <input type="text" name="name" value="{{ old('name', $person->name) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="People Name">
        </div>
        <div class="flex flex-col">
            <label for="number" class="block text-sm font-medium text-gray-900">ID Number</label>
            <input type="text" name="id_number" value="{{ old('id_number', $person->idCard->id_number) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="ID Number">
        </div>
        <div class="flex flex-col">
            <label for="checkbox" class="block text-sm font-medium text-gray-900">Hobby</label>
            @foreach ($hobbies as $hobby)
                <div class="flex flex-row gap-3 mt-2">
                    <input type="checkbox" name="hobby_id[]" id="hobby_id-{{ $hobby->id }}" value="{{ $hobby->id }}"
                    @if(count($person->hobbies->where('id', $hobby->id)))
                        checked 
                    @endif 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5">
                    <label for="hobby_id-{{ $hobby->id }}" class="block text-sm font-medium text-gray-900">{{ $hobby->name }}</label>
                </div>
            @endforeach
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
