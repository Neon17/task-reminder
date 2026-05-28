<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trashed Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12 pt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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


            <h4 class="text-xl font-extrabold text-center">All Trashed Tasks</h4>

            <div class="bg-white shadow-xl sm:rounded-lg m-4 mb-7">

                <div class="relative">
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
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Created By
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Assigned Date For Completion
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Completed Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Created At
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Updated At
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($tasks) == 0)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 w-100">
                                        <p class="text-center">No task found</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($tasks as $task)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4 w-100">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $task->title }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $task->description }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $task->creator->name }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $task->assigned_date }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $task->completed_date }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $task->created_at }}
                                        </td>
                                        <td class="px-1 py-4 w-100">

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
                                                class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-50 hidden actions-dropdown origin-top-right">
                                                <div class="flex flex-col space-y-2 p-2">
                                                    <form action="{{ route('tasks.restore', $task->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                            class="w-full focus:outline-none text-black bg-gray-100 hover:bg-gray-200 hover:text-black focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                                            Restore
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('tasks.forceDelete', $task->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                            class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>



                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
