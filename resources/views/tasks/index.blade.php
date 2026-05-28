<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
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
            @endif

            <a type="button" href="{{ route('tasks.create') }}"
                class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Create
                Task</a>

            <h4 class="text-xl font-extrabold text-center">Your Tasks</h4>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-4 mb-7">

                <div class="relative overflow-x-auto">
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
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($tasks->count() == 0)
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
                                        <td class="px-6 py-4 w-100">
                                            <div class="grid grid-cols-2 w-100">
                                                <a href="{{route('tasks.edit', $task->id)}}" type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">Edit</a>
                                                <form action="{{route('tasks.destroy', $task->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">Delete</button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>


            <h4 class="text-xl font-extrabold text-center mt-5">Tasks you are followers of</h4>


            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-4 mb-7">

                <div class="relative overflow-x-auto">
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

                            @if ($tasks->count() == 0)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 w-100">
                                        <p class="text-center">No task found</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($tasks as $task)
                                    <tr class="bg-white border-b border-gray-200">

                                    </tr>
                                @endforeach
                            @endif
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <h4 class="text-xl font-extrabold text-center">All Tasks</h4>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-4 mb-7">

                <div class="relative overflow-x-auto">
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

                            @if ($tasks->count() == 0)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 w-100">
                                        <p class="text-center">No task found</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($tasks as $task)
                                    <tr class="bg-white border-b border-gray-200">

                                    </tr>
                                @endforeach
                            @endif
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
    </div>
</x-app-layout>
