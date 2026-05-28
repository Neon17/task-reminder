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

            <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md">
                <div class="flex items-center mb-6">
                    <div
                        class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-2xl font-semibold text-gray-600 uppercase">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-600 font-medium">Username</label>
                        <div class="mt-1 text-gray-800">{{ $user->name }}</div>
                    </div>

                    <div>
                        <label class="block text-gray-600 font-medium">Email address</label>
                        <div class="mt-1 text-gray-800">{{ $user->email }}</div>
                    </div>

                    <div>
                        <label class="block text-gray-600 font-medium">Timezone</label>
                        <div class="mt-1 text-gray-800">{{ $user->timezone ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <label class="block text-gray-600 font-medium">Role</label>
                        <div class="mt-1">
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-md text-sm font-medium 
                    {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</x-app-layout>
