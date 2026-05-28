<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">

            <a type="button" href={{ route('notes.exportFiltered', request()->query()) }}
                class="py-2.5 px-5 me-2 mb-2 text-sm float-right font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                {{ __('Export') }}
            </a>

            <form method="GET" class="mt-5 px-5 flex flex-col md:flex-row md:items-center md:justify-start gap-2"
                action="{{ route('notes.index') }}">
                @csrf

                <!-- Search by Title -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="title" class="block text-sm font-medium text-gray-700">
                        {{ __('Search Title') }}
                    </label>
                    <input type="text" name="title" id="title" value="{{ request('title') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- User Filter -->
                @if (count($users) > 0)
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">
                            {{ __('User') }}
                        </label>
                        <select name="user_id" id="user_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">
                                {{ __('All Users') }}
                            </option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif


                <!-- Notes by Task Categories (like yours, you followed, others) -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="category" class="block text-sm font-medium text-gray-700">
                        {{ __('Category by Tasks') }}
                    </label>
                    <select name="category" id="category"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">All</option>
                        <option value="creator" {{ request('category') === 'creator' ? 'selected' : '' }}>
                            {{ __('Your Tasks') }}
                        </option>
                        <option value="follower" {{ request('category') === 'follower' ? 'selected' : '' }}>
                            {{ __('Followed Tasks') }}
                        </option>
                        <option value="others" {{ request('category') === 'others' ? 'selected' : '' }}>
                            {{ __('Others') }}
                        </option>
                    </select>
                </div>

                <!-- Notes by Reason Categories (like creation, deletion, updation) -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="reason" class="block text-sm font-medium text-gray-700">
                        {{ __('Category by Reason') }}
                    </label>
                    <select name="reason" id="reason"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">All</option>
                        <option value="creation" {{ request('reason') === 'creation' ? 'selected' : '' }}>
                            {{ __('creation') }}
                        </option>
                        <option value="completion" {{ request('reason') === 'completion' ? 'selected' : '' }}>
                            {{ __('completion') }}
                        </option>
                        <option value="updation" {{ request('reason') === 'updation' ? 'selected' : '' }}>
                            {{ __('updation') }}
                        </option>
                        <option value="deletion" {{ request('reason') === 'deletion' ? 'selected' : '' }}>
                            {{ __('deletion') }}
                        </option>
                    </select>
                </div>

                <!-- Sort Options -->
                <div class="mb-4 w-full md:w-auto">
                    <label for="sort" class="block text-sm font-medium text-gray-700">{{ __('Sort By') }}</label>
                    <select name="sort" id="sort"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">{{ __('Default') }}</option>
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>
                            {{ __('Created (Oldest)') }}
                        </option>
                        <option value="-created_at" {{ request('sort') === '-created_at' ? 'selected' : '' }}>
                            {{ __('Created (Newest)') }}
                        </option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>

            <h4 class="text-xl font-extrabold text-center">{{ __('All Notes') }}</h4>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-4 mb-7">

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
                                                    <img src="{{ $note->user->avatar || 'https://ui-avatars.com/api/?name=' . $note->user->name }}"
                                                        class="w-5 h-5 rounded-full mr-1">
                                                    {{ $note->user->name }}
                                                    <a href="{{ route('users.show', $note->user) }}"
                                                        class="ml-1 text-blue-400 hover:text-blue-600">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
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

        </div>
    </div>
</x-app-layout>
