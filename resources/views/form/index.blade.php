@extends('layouts.app')

@section('title', 'Input')
@section('body')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">All Input</h1>
        <a href="{{ route('form.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create New Form</a>
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mt-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="mt-6 table-fixed w-full text-sm rounded-lg">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm border">
                <tr class=" ">
                    <th class="border px-4 py-2">Text</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Password</th>
                    <th class="border px-4 py-2">Checkbox</th>
                    <th class="border px-4 py-2">Radio</th>
                    <th class="border px-4 py-2">Select</th>
                    <th class="border px-4 py-2">File</th>
                    <th class="border px-4 py-2">Textarea</th>
                    <th class="border px-4 py-2">Date</th>
                    <th class="border px-4 py-2">Number</th>
                    <th class="border px-4 py-2">Range</th>
                    <th class="border px-4 py-2">Color</th>
                    <th class="border px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inputs as $input)
                    <tr>
                        <td class="border px-4 py-2 text-center truncate">{{ $input->text }}</td>
                        <td class="border px-4 py-2 text-center relative group">
                            <div class="truncate" style="max-width: 200px">{{ $input->email }}</div>
                            <div class="absolute left-0 top-full mt-2 hidden group-hover:block bg-gray-700 text-white text-sm p-2 rounded-lg shadow-lg" style="min-width: 200px">{{ $input->email }}</div>
                        </td>
                        <td class="border px-4 py-2 text-center truncate">{{ $input->password }}</td>
                        <td class="border px-4 py-2 text-center truncate">
                            @if($input->checkbox)
                                @foreach(json_decode($input->checkbox) as $checkbox)
                                    <span>{{ $checkbox }}</span>
                                    <br>
                                @endforeach
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-center truncate">{{ $input->radio }}</td>
                        <td class="border px-4 py-2 text-center truncate">{{ $input->select }}</td>
                        <td class="border px-4 py-2 text-center truncate">
                            @if($input->file)
                                <a href="{{ asset('storage/' . $input->file) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $input->file) }}" alt="Uploaded file" class="w-20 h-20 object-cover">
                                </a>
                            @else
                                No file uploaded
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-center relative group">
                            <div class="truncate" style="max-width: 200px">{{ $input->textarea }}</div>
                            <div class="absolute left-0 top-full mt-2 hidden group-hover:block bg-gray-700 text-white text-sm p-2 rounded-lg shadow-lg" style="min-width: 200px">{{ $input->textarea }}</div>
                        </td>
                        <td class="border px-4 py-2 text-center truncate">{{ $input->date }}</td>
                        <td class="border px-4 py-2 text-center truncate">{{ $input->number }}</td>
                        <td class="border px-4 py-2 text-center truncate">{{ $input->range }}</td>
                        <td class="border px-4 py-2 text-center truncate"><div class="w-10 h-10 rounded-lg bg-[{{ $input->color }}]"></div></td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex space-x-2 flex-col justify-center items-center gap-2">
                                <a href="{{ route('form.edit', $input->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>
                                <form action="{{ route('form.destroy', $input->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $inputs->links() }}
        </div>
    </div>
@endsection