{{-- Admin should be able to create and add users --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="p-0 sm:p-5">
        <div class="bg-white mx-auto sm:px-6 lg:px-8 p-5">



            <form action="{{ route('users.store') }}" class="mx-auto flex flex-col" method="POST">
                @csrf
                @method('POST')
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="username" id="username"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="username"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{__("Username")}}
                    </label>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="email" id="email"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{__("Email Address")}}
                    </label>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="password" id="password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{__("Password")}}
                    </label>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="confirm_password" id="confirm_password"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " required />
                    <label for="confirm_password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{__("Confirm Password")}}
                    </label>
                    @error('confirm_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group flex flex-col">
                    <label for="confirm_password"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-2 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            {{__("Select Timezone")}}
                    </label>
                    <select name="timezone" class="form-select text-gray-600" required>
                        @foreach ($timezones as $tz)
                            <option value="{{ $tz['value'] }}"
                                {{ old('timezone', $user->timezone ?? '') === $tz['value'] ? 'selected' : '' }}>
                                {{ $tz['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <div class="space-y-4 text-gray-500">
                            <div class="flex items-center mb-3">
                                {{__("Role:")}}
                            </div>
                            <div class="flex items-center m-2">
                                <input id="role_user" name="role" type="radio" value="user"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                    {{ old('role', $user->role ?? '') == 'user' ? 'checked' : '' }}>
                                <label for="role_user" class="ml-2 block text-sm font-medium text-gray-500">
                                    {{__("Standard User")}}
                                </label>
                            </div>

                            <div class="flex items-center m-2">
                                <input id="role_admin" name="role" type="radio" value="admin"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                    {{ old('role', $user->role ?? '') == 'admin' ? 'checked' : '' }}>
                                <label for="role_admin" class="ml-2 block text-sm font-medium text-gray-500">
                                    {{__("Administrator")}}
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="buttoncontainer">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{__("Create")}}
                    </button>
                </div>
            </form>


        </div>
    </div>
</x-app-layout>
