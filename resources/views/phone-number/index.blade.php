@extends('layouts.app')

@section('title', 'Phone Number')
@section('body')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">Phone Number</h1>
        <a href="{{ route('phone-number.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New</a>
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mt-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="mt-6 table-fixed w-full text-sm rounded-lg">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm border">
                <tr class=" ">
                    <th class="border px-4 py-2 w-[50px]">No.</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Phone Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($phoneNumbers as $phoneNumber)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2 text-center truncate">{{ $phoneNumber->people->name }}</td>
                        <td class="border px-4 py-2 text-center">{{ $phoneNumber->phone_number }}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('phone-number.edit', $phoneNumber->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>
                                <form action="{{ route('phone-number.destroy', $phoneNumber->id) }}" method="POST">
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
            {{ $phoneNumbers->links() }}
        </div>
    </div>
@endsection