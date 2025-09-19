@extends('layouts.app')

@section('title', 'Create')

@section('body')
        <h1 class="text-2xl font-bold mb-6">Create People</h1>
            <form class="max-w-sm mx-auto flex flex-col gap-2 mt-4" action="{{ route('people.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col">
                    <label for="text" class="block text-sm font-medium text-gray-900">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="Text">
                </div>
                <div class="flex flex-col">
                    <label for="number" class="block text-sm font-medium text-gray-900">ID Number</label>
                    <input type="text" name="id_number" value="{{ old('id_number') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[300px] p-2.5" placeholder="ID Number">
                </div>
                <div class="flex flex-col">
                    <label for="phone" class="block text-sm font-medium text-gray-900">Phone Numbers (Optional)</label>
                    <div id="phone-numbers-container">
                        @if(old('phone_numbers'))
                            @foreach(old('phone_numbers') as $index => $phone)
                                <div class="phone-number-field flex items-center gap-2 mb-2">
                                    <input type="text" name="phone_numbers[]" value="{{ $phone }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[250px] p-2.5" placeholder="Phone Number">
                                    <button type="button" onclick="removePhoneField(this)" class="bg-red-500 text-white px-3 py-2 rounded text-sm">Remove</button>
                                </div>
                            @endforeach
                        @else
                            <div class="phone-number-field flex items-center gap-2 mb-2">
                                <input type="text" name="phone_numbers[]" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[250px] p-2.5" placeholder="Phone Number">
                                <button type="button" onclick="removePhoneField(this)" class="bg-red-500 text-white px-3 py-2 rounded text-sm">Remove</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" onclick="addPhoneField()" class="bg-green-500 text-white px-4 py-2 rounded text-sm w-fit mt-2">Add Phone Number</button>
                </div>
                <div class="flex flex-col">
                    <label for="checkbox" class="block text-sm font-medium text-gray-900">Hobby</label>
                    @foreach ($hobbies as $hobby)
                        <div class="flex flex-row gap-3 mt-2">
                            <input type="checkbox" name="hobby_id[]" id="hobby_id-{{ $hobby->id }}" value="{{ $hobby->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5">
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

<script>
function addPhoneField() {
    const container = document.getElementById('phone-numbers-container');
    const phoneFieldCount = container.children.length;
    
    const newField = document.createElement('div');
    newField.className = 'phone-number-field flex items-center gap-2 mb-2';
    newField.innerHTML = `
        <input type="text" name="phone_numbers[]" value="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block min-w-[250px] p-2.5" placeholder="Phone Number">
        <button type="button" onclick="removePhoneField(this)" class="bg-red-500 text-white px-3 py-2 rounded text-sm">Remove</button>
    `;
    
    container.appendChild(newField);
}

function removePhoneField(button) {
    const container = document.getElementById('phone-numbers-container');
    if (container.children.length > 1) {
        button.parentElement.remove();
    } else {
        alert('Minimal harus ada 1 field phone number');
    }
}
</script>

@endsection