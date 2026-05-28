<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trashed Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12 pt-2">
        <div class="mx-auto sm:px-6 lg:px-8">

            <x-session-message />

            <h4 class="text-xl font-extrabold text-center">{{__("All Trashed Tasks")}}</h4>

            <div class="bg-white shadow-xl sm:rounded-lg m-4 mb-7">

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{__("SN")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Name")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Description")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Created By")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Assigned Date For Completion")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Completed Date")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Created At")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Actions")}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($tasks) == 0)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 w-100">
                                        <p class="text-center">
                                            {{__("No task found")}}
                                        </p>
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
                                                            {{__("Restore")}}
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('tasks.forceDelete', $task->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                            class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                                            {{__("Delete")}}
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
