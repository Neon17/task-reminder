{{-- Admin should be able to create and add users --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 py-5">

            <!-- resources/views/users/show.blade.php -->

<div class="max-w-3xl mx-auto py-8">
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-white">User Details</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('users.edit', $user) }}" 
                       class="px-3 py-1 bg-white/20 hover:bg-white/30 rounded-md text-sm font-medium text-white transition">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- User Information -->
        <div class="px-6 py-8 space-y-6">
            <!-- Profile Summary -->
            <div class="flex items-center space-x-4">
               <div class="flex-shrink-0 h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                    @if($user->profile_photo_path)
                        <img 
                            src="{{ $user->profile_photo_url }}" 
                            alt="{{ $user->name }}"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <span class="text-2xl font-medium text-blue-800">
                            {{ strtoupper(substr($user->username, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $user->username }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Username -->
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-gray-500">Username</h3>
                    <p class="text-gray-900">{{ $user->name }}</p>
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-gray-500">Email address</h3>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>

                <!-- Timezone -->
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-gray-500">Timezone</h3>
                    <p class="text-gray-900">{{ $user->timezone }}</p>
                </div>

                <!-- Role -->
                <div class="space-y-1">
                    <h3 class="text-sm font-medium text-gray-500">Role</h3>
                    <p class="text-gray-900 capitalize">{{ $user->role }}</p>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
            <div class="flex items-center">
                <div class="h-2 w-2 rounded-full bg-green-500 mr-2"></div>
                <span class="text-sm font-medium text-gray-700">Active</span>
            </div>
        </div>
    </div>
</div>

        </div>
</x-app-layout>
