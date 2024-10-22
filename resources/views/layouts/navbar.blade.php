<nav class="bg-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <h1 class="text-black font-bold text-2xl">Forms</h1>
                </div>
                <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                    <a href="/" class="text-black px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="{{ route('people.index') }}" class="text-black px-3 py-2 rounded-md text-sm font-medium">People</a>
                    <a href="{{ route('phone-number.index') }}" class="text-black px-3 py-2 rounded-md text-sm font-medium">Phone Number</a>
                    <a href="{{ route('hobbies.index') }}" class="text-black px-3 py-2 rounded-md text-sm font-medium">Hobbies</a>
                    <a href="{{ route('form.index') }}" class="text-black px-3 py-2 rounded-md text-sm font-medium">Forms</a>
                </div>
                </div>
            </div>
    </div>
</nav>