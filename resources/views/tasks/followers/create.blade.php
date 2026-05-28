<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Task Followers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            @if (session('success'))
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
            @elseif(session('error'))
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

            <h4 class="text-xl font-extrabold text-center mt-3 mb-2">Add Followers</h4>

            <form action="{{ route('task.followers.store', $task) }}" method="post">
                @csrf
                
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                    <div class="relative overflow-x-auto">
                        @csrf


                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        SN
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Role
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Timezone
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->count() == 0)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4 w-100">
                                            <p class="text-center">No users who unfollowed this task found</p>
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($users as $user)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4">
                                            {{ $loop->iteration }}
                                        </td>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
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
                                        <td class="px-6 py-4 flex">

                                            <input type="checkbox" name="selected_users[]" value="{{ $user->id }}"
                                                class="mr-2">

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
                <button type="submit"
                    class="text-gray-900 mt-3 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Update
                    Selected Followers</button>
            </form>
        </div>
    </div>
</x-app-layout>
