<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminder: ') }} @if ($task)
                {{ $task->title }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12 pt-2">
        <div class="mx-auto sm:px-6 lg:px-8">

            <x-session-message />

            <div class="relative overflow-x-auto p-5 mt-5 bg-white">
                <div class="button-direction flex justify-end">
                    @if ($task->completed_date)
                        <a type="button"
                            class="text-white bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                            {{ __('Completed') }}
                        </a>
                    @else
                        @if ($task->canComplete())
                            <a type="button" href="{{ route('tasks.edit', $task) }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                                {{ __('Edit') }}

                            </a>
                            <form action="{{ route('tasks.delete', $task->id) }}" class="mx-2" method="post">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
                <form class="mx-auto">

                    <div class="edit-field-container flex flex-col gap-5">
                        <x-form.input type="text" name="title" :value="$task->title" label="Title" editable="false" />
                        <x-form.input type="text" name="description" :value="$task->description" label="Description" editable="false" />
                        <x-form.input type="datetime-local" name="date_of_completion" label="Complete Date" :value="$task->assigned_date" editable="false" />
                        <x-form.input type="number" name="notification_interval" label="Notification Interval (in days)" :value="$task->notification_interval"  editable="false" />
                    </div>

                    <div class="relative z-0 flex gap-3 mb-5 mt-5 group">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Created By') }}
                        </label>
                        @if ($task->creator)
                            <div
                                class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-1.5 rounded flex items-center">
                                {{ $task->creator->name }}
                                <a href="{{ route('users.show', $task->creator) }}"
                                    class="ml-1 text-blue-400 hover:text-blue-600">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        @endif
                        </a>
                    </div>
                </form>

            </div>

            <div class="relative overflow-x-auto p-5 my-3 bg-white">
                <!-- Followers Field -->
                <div class="relative overflow-x-auto mb-3 bg-white">
                    <h4 class="">
                        {{ __('Followers') }}
                    </h4>

                    <div class="mt-3 flex flex-wrap gap-2">
                        @if ($task->followers->count() == 0)
                            <p class="text-gray-500">{{ __('No followers found') }}</p>
                        @else
                            @foreach ($task->followers as $follower)
                                <div
                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-2.5 rounded flex items-center">
                                    {{ $follower->name }}
                                    <a href="{{ route('users.show', $follower) }}"
                                        class="ml-1 text-blue-400 hover:text-blue-600">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>


            @if (count($notes) > 0)
                <h4 class="text-xl font-extrabold text-center mt-5 mb-2">{{ __('Notes') }}</h4>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-7">

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('SN') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Description') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Creator') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Task') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Reason') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Assigned Date') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        {{ __('Created Date') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (count($notes) == 0)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4 w-100">
                                            <p class="text-center">{{ __('No notes found') }}</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($notes as $note)
                                        <tr class="bg-white border-b border-gray-200">
                                            <td class="px-6 py-4 w-100">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                {{ Str::words($note->description, 6, '...') }}
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                <div class="flex">
                                                    <div value ="{{ $note->user->id }}"
                                                        class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-2.5 rounded flex items-center">
                                                        {{ $note->user->name }}
                                                        <a href="{{ route('users.show', $note->user) }}"
                                                            class="ml-1 text-blue-400 hover:text-blue-600">
                                                            <svg class="w-3 h-3" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                @if ($note->task)
                                                    {{ $note->task->title }}
                                                @else
                                                    <em>{{ __('Deleted') }}</em>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                {{ $note->reason }}
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                @if ($note->task)
                                                    {{ $note->task->assigned_date }}
                                                @else
                                                    <em>{{ __('Deleted') }}</em>
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

                </div>
                {{ $notes->links() }}
            @endif




        </div>
    </div>
</x-app-layout>
