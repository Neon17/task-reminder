@props(['user' => null, 'isEdit' => false])

@php
    $roles = ['user' => 'Standard User', 'admin' => 'Administrator'];
@endphp

<form method="POST" action="{{ $isEdit ? route('users.update', $user) : route('users.store') }}">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <!-- Username -->
        <div>
            <x-form.input name="name" label="Username" value="{{ old('name', $user->name ?? '') }}" />
            <label class="block text-gray-700 font-medium mb-1">Username</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
        </div>

        <!-- Timezone -->
        <div class="sm:col-span-2">
            <label class="block text-gray-700 font-medium mb-1">Select Timezone</label>
            <select name="timezone"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
                @foreach(timezone_identifiers_list() as $tz)
                    <option value="{{ $tz }}" {{ old('timezone', $user->timezone ?? '') === $tz ? 'selected' : '' }}>
                        {{ '(UTC' . now()->setTimezone($tz)->format('P') . ') — ' . $tz }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Role -->
        <div class="sm:col-span-2">
            <label class="block text-gray-700 font-medium mb-1">Role</label>
            <div class="flex gap-4">
                @foreach($roles as $value => $label)
                    <label class="inline-flex items-center">
                        <input type="radio" name="role" value="{{ $value }}"
                            {{ old('role', $user->role ?? 'user') === $value ? 'checked' : '' }}
                            class="form-radio text-blue-600">
                        <span class="ml-2 text-gray-700">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Password (only for create) -->
        @unless($isEdit)
            <div>
                <label class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
            </div>
        @endunless
    </div>

    <div class="mt-6">
        <button type="submit"
            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            {{ $isEdit ? 'Update User' : 'Create User' }}
        </button>
    </div>
</form>
