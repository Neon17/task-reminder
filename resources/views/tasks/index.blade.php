<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminders') }}
        </h2>
    </x-slot>

    <div class="py-12 pt-2">
        <div class="mx-auto sm:px-6 lg:px-8">

            <x-session-message />

            <a type="button" href="{{ route('tasks.create') }}"
                class="py-2.5 px-5 me-2 mb-2 ms-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                {{ __('Create Reminder') }}
            </a>

            <a type="button" href={{ route('tasks.exportFiltered', request()->query()) }}
                class="py-2.5 px-5 me-2 mb-2 text-sm md:float-right font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                {{ __('Export') }}
            </a>

            <form method="GET" class="mt-5 px-5 flex flex-col md:flex-row md:items-center md:justify-start gap-2"
                action="{{ route('tasks.index') }}">
                <!-- Search by Title -->
                @csrf
                <div class="mb-4 w-full md:w-auto">
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        {{ __('Search Title') }}
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', request('title')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Status Filter -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="status" class="block text-sm font-medium text-gray-700">
                        {{ __('Status') }}
                    </label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Pending/Completed</option>
                        <option value="pending" {{ old('status', request('status')) === 'pending' ? 'selected' : '' }}>
                            {{ __('Pending') }}
                        </option>
                        <option value="completed"
                            {{ old('status', request('status')) === 'completed' ? 'selected' : '' }}>
                            {{ __('Completed') }}
                        </option>
                        <option value="trashed" {{ old('status', request('status')) === 'trashed' ? 'selected' : '' }}>
                            {{ __('Trashed') }}
                        </option>
                    </select>
                </div>

                <!-- Assignee Filter -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="assignee" class="block text-sm font-medium text-gray-700">
                        {{ __('Creators and Followers') }}
                    </label>
                    <select name="assignee" id="assignee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">
                            {{ __('All') }}
                        </option>
                        <option value="creator"
                            {{ old('assignee', request('assignee')) === 'creator' ? 'selected' : '' }}>
                            {{ __('Created By You') }}
                        </option>
                        <option value="follower"
                            {{ old('assignee', request('assignee')) === 'follower' ? 'selected' : '' }}>
                            {{ __('Followed By You') }}
                        </option>
                        <option value="others">
                            {{ __('Neither') }}
                        </option>
                    </select>
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
                        <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>
                            {{ __('Title (A-Z)') }}
                        </option>
                        <option value="-title" {{ request('sort') === '-title' ? 'selected' : '' }}>
                            {{ __('Title (Z-A)') }}
                        </option>
                        <option value="assigned_date" {{ request('sort') === 'assigned_date' ? 'selected' : '' }}>
                            {{ __('Assigned Date (Oldest)') }}
                        </option>
                        <option value="-assigned_date" {{ request('sort') === '-assigned_date' ? 'selected' : '' }}>
                            {{ __('Assigned Date (Newest)') }}
                        </option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>

            <div class="bg-white shadow-xl sm:rounded-lg m-4 mb-7">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-900 table-auto">
                        <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('SN') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Title') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Description') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Created By') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Complete_Date') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Complete') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Followers') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($tasks) == 0)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 w-100">
                                        <p class="text-center">
                                            {{ __('No task found') }}
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
                                            {{ Str::words($task->title, 4, '...') }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ Str::limit($task->description, 35, '...') }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            <div class="flex">
                                                <div value ="{{ $task->creator ? $task->creator->id : '' }}"
                                                    class="text-sm font-medium px-2.5 py-2.5 rounded flex items-center">
                                                    @if ($task->creator)
                                                        <a href="{{ route('users.show', $task->creator ? $task->creator->id : '') }}"
                                                            class="text-gray-900 bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                            {{ Str::limit($task->creator->name, 11, '...') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $task->assigned_date }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            @if ($task->completed_date)
                                                {{ __('Yes') }}
                                            @else
                                                <p class="text-gray-300">
                                                    {{ __('No') }}
                                                </p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            @if ($task->followers->count() == 0)
                                                <p class="text-gray-300">
                                                    {{ __('No follower') }}
                                                </p>
                                            @elseif ($task->followers->count() == 1)
                                                @foreach ($task->followers as $follower)
                                                    <div class="flex">
                                                        <div value ="{{ $follower->id }}"
                                                            class="text-sm font-medium px-2.5 py-2.5 rounded flex items-center">
                                                            <a href="{{ route('users.show', $follower->id) }}"
                                                                class=" bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                                {{ Str::limit($follower->name, 11, '...') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <button type="button"
                                                    class="text-gray-900 flex items-center hover:text-gray-700 focus:outline-none transition-all duration-200 action-toggle"
                                                    onclick="toggleActions(this)">
                                                    <a href="{{ route('users.show', $task->followers[0]->id) }}"
                                                        class="text-gray-900 bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                        {{ Str::limit($task->followers[0]->name, 6, '...') }}
                                                        {{ __('+ ') }}
                                                        {{ $task->followers->count() - 1 }}
                                                    </a>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>

                                                <!-- Vertical Actions dropdown -->
                                                <div
                                                    class="absolute mt-2 w-32 bg-white rounded-md shadow-lg z-50 hidden actions-dropdown right-0 lg:right-auto">
                                                    <div class="flex flex-col space-y-2 p-2">
                                                        @foreach ($task->followers as $follower)
                                                            @if ($loop->index > 0)
                                                                <a href="{{ route('users.show', $follower->id) }}"
                                                                    class="text-gray-900 bg-white focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                                    {{ Str::limit($follower->name, 11, '...') }}
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            <button type="button"
                                                class="text-gray-900 hover:text-gray-700 focus:outline-none transition-all duration-200 action-toggle"
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
                                                class="absolute w-32 bg-white rounded-md shadow-lg z-50 hidden right-0 lg:right-auto actions-dropdown">
                                                <div class="flex flex-col space-y-2 p-2">
                                                    @if (request('status') && request('status') == 'trashed')
                                                        <form action="{{ route('tasks.restore', $task->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit"
                                                                class="w-full text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                                {{ __('Restore') }}
                                                            </button>
                                                        </form>
                                                    @else
                                                        @if ($task->canDelete() && $task->completed_date == null)
                                                            <a href="{{ route('tasks.edit', $task->id) }}"
                                                                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                                {{ __('Edit') }}
                                                            </a>
                                                            <a href="{{ route('tasks.complete', $task->id) }}"
                                                                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                                {{ __('Complete') }}
                                                            </a>
                                                            <form action="{{ route('tasks.delete', $task->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('POST')
                                                                <button type="submit"
                                                                    class="w-full focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center">
                                                                    {{ __('Delete') }}
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="{{ route('tasks.show', $task->id) }}"
                                                                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                                {{ __('View') }}
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            @endif

            <div class="mx-3">
                {{ $tasks->links() }}
            </div>

        </div>


    </div>
</x-app-layout>
