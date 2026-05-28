@props(['user' => null, 'isEdit' => false])

<form method="POST" action="{{ $user ? route('users.update', $user) : route('users.store') }}" class="space-y-6">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
            {{ $isEdit ? 'Edit User' : 'Create New User' }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Username Field -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="username" name="username" value="{{ old('username', $user->name ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 border"
                    required>
                    @error('username')
                        <p class="text-red-800">{{$message}}</p>
                    @enderror
            </div>

            <!-- Email Field -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Email address</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 border"
                    required>
                @error('email')
                       <p class="text-red-800">{{$message}}</p> 
                @enderror
            </div>

            <!-- Timezone Field -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Timezone</label>
                <select name="timezone" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 border">
                    @foreach(timezone_identifiers_list() as $timezone)
                        <option value="{{ $timezone }}" {{ ($user->timezone ?? 'UTC') === $timezone ? 'selected' : '' }}>
                            {{ $timezone }}
                        </option>
                    @endforeach
                </select>
                    @error('timezone')
                        <p class="text-red-800">{{$message}}</p>
                    @enderror
            </div>

            @if (!$user)
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" value=""
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 border"
                        required>
                    @error('password')
                        <p class="text-red-800">{{$message}}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="confirm_password" value=""
                        class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 border"
                        required>
                    @error('confirm_password')
                        <p class="text-red-800">{{$message}}</p>
                    @enderror
                 </div>
            @endif
            <!-- Role Field -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="role" class="mt-1 block w-full rounded-md border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-3 border">
                    <option value="user" {{ ($user->role ?? 'user') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ ($user->role ?? 'user') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>

        <div class="flex justify-end mt-8 space-x-3">
            <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ $isEdit ? 'Update User' : 'Create User' }}
            </button>
        </div>
    </div>
</form>