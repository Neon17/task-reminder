<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">


            <div class="relative overflow-x-auto p-5 bg-white">
                <form class="mx-auto" action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <h4 class="text-xl font-extrabold text-center mb-3">{{__("Task Details")}}</h4>

                    <div class="edit-field-container">

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="title" id="floating_first_name"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                value="{{ $task->title }}" placeholder=" " required />
                            <label for="floating_first_name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{__("Title")}}
                            </label>
                            @error('title')
                                <div class="mt-1 flex items-center text-sm text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="description" id="floating_first_name"
                                value="{{ $task->description }}"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_first_name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{__("Description")}}
                            </label>
                            @error('description')
                                <div class="mt-1 flex items-center text-sm text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="datetime-local" name="date_of_completion" id="floating_first_name"
                                value="{{ $task->assigned_date }}"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_first_name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{__("Assigned Date of Completion")}}
                            </label>
                            @error('date_of_completion')
                                <div class="mt-1 flex items-center text-sm text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="datetime-local" name="notification_start_date" id="floating_first_name"
                                value="{{ $task->notification_start_date }}"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_first_name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{__("Notification Start Date")}}
                            </label>
                            @error('notification_start_date')
                                <div class="mt-1 flex items-center text-sm text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="number" name="notification_interval" id="floating_first_name"
                                value="{{ $task->notification_interval }}"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <label for="floating_first_name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{__("Notification Interval (in days)")}}
                            </label>
                            @error('notification_interval')
                                <div class="mt-1 flex items-center text-sm text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                    </div>

                    <div class="notes-fields">

                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900">
                            {{__("Your Notes")}}
                        </label>
                        <textarea id="message" rows="4" name="notes" required
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Write your reason for the task updation here..."></textarea>
                        @error('notes')
                            <div class="mt-1 flex items-center text-sm text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="flex gap-3"></div>
                    <button type="submit"
                        class="text-white mt-1 bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        {{__("Update")}}
                    </button>

                    @if ($task->canComplete())
                        <a type="button" href="{{ route('tasks.complete', $task) }}"
                            class="text-white mt-1 bg-gray-600 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                            {{__("Go to Task Completion")}}
                        </a>
                    @endif
                </form>

            </div>

            <div class="relative overflow-x-auto mt-5 p-5 bg-white">
                <h4 class="text-xl font-extrabold text-center mb-3">{{__("Created By")}}</h4>


                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{__("Name")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Email")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Timezone")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Role")}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">
                                {{ $task->creator->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $task->creator->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $task->creator->timezone }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $task->creator->role }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="relative overflow-x-auto mt-5 p-5 bg-white">
                <h4 class="text-xl font-extrabold text-center mb-3">{{__("Notes")}}</h4>

                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{__("SN")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Description")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("User")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Task")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Reason")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Assigned Date")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Created Date")}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (count($task->notes) == 0)
                            <tr class="bg-white border-b border-gray-200">
                                <td class="px-6 py-4 w-100">
                                    <p class="text-center">{{__("No notes found")}}</p>
                                </td>
                            </tr>
                        @else
                            @foreach ($task->notes as $note)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 w-100">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        {{ $note->description }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        {{ $note->user->name }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        @if ($note->task)
                                            {{ $note->task->title }}
                                        @else
                                            <em>{{__("Deleted")}}</em>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        {{ $note->reason }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        @if ($note->task)
                                            {{ $note->task->assigned_date }}
                                        @else
                                            <em>{{__("Deleted")}}</em>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        {{ $note->created_at }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tr>
                    </tbody>
                </table>

            </div>

            <div class="relative overflow-x-auto p-5 mt-5 bg-white">
                <h4 class="text-xl font-extrabold text-center">{{__("Followers")}}</h4>

                <a href="{{ route('task.followers.create', $task) }}" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                    {{__("Add Followers")}}
                </a>


                <table class="w-full mt-3 text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{__("SN")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Name")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Email")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Role")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Timezone")}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{__("Action")}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($task->followers->count() == 0)
                            <tr class="bg-white border-b border-gray-200">
                                <td class="px-6 py-4 w-100">
                                    <p class="text-center">{{__("No followers found")}}</p>
                                </td>
                            </tr>
                        @else
                            @foreach ($task->followers as $follower)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 w-100">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        {{ $follower->name }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        {{ $follower->email }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        {{ $follower->role }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        {{ $follower->timezone }}
                                    </td>
                                    <td class="px-6 py-4 w-100">
                                        <form method="POST"
                                            action="{{ route('task.followers.destroy', [$task, $follower]) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">
                                                {{__("Detach Follower")}}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
