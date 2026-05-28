<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="pt-2 pb-3">
        <div class="mx-auto sm:px-6 lg:px-8">


            <div class="error-container" style="min-height: 60px;">
                @if (session('error'))
                    <div class="alert alert-error mb-4">
                        <div
                            class="flex items-center justify-between px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button type="button" class="text-red-700 hover:text-red-900"
                                onclick="this.parentElement.parentElement.remove()">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @elseif(session('success'))
                    <div class="alert alert-success mb-4">
                        <div
                            class="flex items-center justify-between px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button type="button" class="text-green-700 hover:text-green-900"
                                onclick="this.parentElement.parentElement.remove()">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>



            <a type="button" href="{{ route('users.create') }}"
                class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                {{ __('Create User') }}
            </a>

            <form method="GET" class="mt-5 px-5 flex flex-col md:flex-row md:items-center md:justify-start gap-2"
                action="{{ route('users.index') }}">

                <div class="mb-4 w-full md:w-auto">
                    <label for="search" class="block text-sm font-medium text-gray-700">
                        {{ __('Search Name/Email') }}
                    </label>
                    <input type="text" name="search" id="search" value="{{ old('search', request('search')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Email Status Filter -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <select name="email" id="email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">
                            {{ __('All') }}
                        </option>
                        <option value="unverified" {{ old('email', request('email')) === 'unverified' ? 'selected' : '' }}>
                            {{ __('Unverified') }}
                        </option>
                        <option value="verified"
                            {{ old('email', request('email')) === 'verified' ? 'selected' : '' }}>
                            {{ __('Verified') }}
                        </option>
                    </select>
                </div>

                <!-- Role Filter -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="role" class="block text-sm font-medium text-gray-700">
                        {{ __('Role') }}
                    </label>
                    <select name="role" id="role"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">
                            {{ __('All') }}
                        </option>
                        <option value="admin" {{ old('role', request('role')) === 'admin' ? 'selected' : '' }}>
                            {{ __('Admin') }}
                        </option>
                        <option value="user" {{ old('role', request('role')) === 'user' ? 'selected' : '' }}>
                            {{ __('User') }}
                        </option>
                    </select>
                </div>

                <!-- Timezone Filter -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="timezone-_selector" class="block text-sm font-medium text-gray-700">
                        {{ __('Timezone') }}
                    </label>
                    <div class="flex flex-col">
                        <select name="timezone" id="timezone-_selector" wire:model="state.timezone"
                            class="form-select text-gray-600">
                            <option value="">
                                {{ __('Select Timezone') }}
                            </option>
                            @foreach (App\Helpers\TimezoneHelper::all() as $tz)
                                <option value="{{ $tz['value'] }}"
                                    {{ old('timezone') === $tz['value'] ? 'selected' : '' }}>
                                    {{ $tz['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="sort" class="block text-sm font-medium text-gray-700">
                        {{ __('Sort By') }}
                    </label>
                    <select name="sort" id="sort"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">
                            {{ __('Default') }}
                        </option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>
                            {{ __('Name (A-Z)') }}
                        </option>
                        <option value="-name" {{ request('sort') === '-name' ? 'selected' : '' }}>
                            {{ __('Name (Z-A)') }}
                        </option>
                        <option value="created_date" {{ request('sort') === 'created_date' ? 'selected' : '' }}>
                            {{ __('Created Date (Oldest)') }}
                        </option>
                        <option value="-created_date" {{ request('sort') === '-created_date' ? 'selected' : '' }}>
                            {{ __('Created Date (Newest)') }}
                        </option>
                    </select>
                </div>


                <div class="h-full py-auto flex justify-center items-center mb-4">
                    <input id="default-checkbox" name="export_excel" type="checkbox" value="true"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500">
                    <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900">Export to Excel</label>
                </div>


                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>


            <div class="bg-white m-2 overflow-hidden shadow-xl sm:rounded-lg mt-5">


                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('SN') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Email') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Role') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Timezone') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4">
                                        {{ $loop->iteration }}
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $user->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->role }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->timezone }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <button type="button"
                                            class="text-gray-500 hover:text-gray-700 focus:outline-none transition-all duration-200 action-toggle"
                                            onclick="toggleActions(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <!-- Vertical Actions dropdown -->
                                        <div
                                            class="absolute w-32 bg-white rounded-md shadow-lg z-50 hidden actions-dropdown origin-top-right">
                                            <div class="flex flex-col space-y-2 p-2">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                    {{ __('Edit') }}
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
