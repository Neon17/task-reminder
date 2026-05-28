<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">

            <a type="button" href={{ route('notes.exportFiltered', request()->query()) }}
                class="py-2.5 px-5 mx-5 mb-2 text-sm md:float-right font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
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
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('notes.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-4 mb-7">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-900">
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
                                                    class="text-sm font-medium px-2.5 py-2.5 rounded flex items-center">
                                                    <a href="{{ route('users.show', $note->user) }}"
                                                        class="text-gray-900 bg-white focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                        {{ $note->user->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            @if ($note->task)
                                                <a href="{{ route('tasks.show', $note->task) }}"
                                                    class="text-gray-900 bg-white focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-2 text-center whitespace-nowrap">
                                                    {{ $note->task->title }}
                                                </a>
                                            @else
                                                <em class="px-3 py-2">{{ __('Deleted') }}</em>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 w-100 text-gray-900">
                                            {{ $note->reason }}
                                        </td>
                                        <td class="px-6 py-4 w-100 text-gray-900">
                                            @if ($note->task)
                                                {{ $note->task->assigned_date }}
                                            @else
                                                <em>{{ __('Deleted') }}</em>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 w-100 text-gray-900">
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
