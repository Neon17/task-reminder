<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminder: ') }} @if ($task)
                {{ $task->title }}
            @endif
        </h2>
    </x-slot>

    <div class="p-2">
        <div class="mx-auto sm:px-6 lg:px-8">

            <x-session-message />

            <div class="buttons my-3">
                @if ($task->canComplete())
                    <a type="button" href="{{ route('tasks.complete', $task) }}"
                        class="text-white bg-gray-600 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        {{ __('Complete Task') }}
                    </a>
                @endif
            </div>

            <div class="relative overflow-x-auto p-5 bg-white">
                <form class="mx-auto" action="{{ route('tasks.update', $task) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <h4 class="text-xl font-extrabold text-center mb-3">{{ __('Task Details') }}</h4>

                    <div class="edit-field-container">

                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="title" id="floating_first_name"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                value="{{ $task->title }}" placeholder=" " required />
                            <label for="floating_first_name"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                {{ __('Title') }}
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
                                {{ __('Description') }}
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
                                {{ __('Assigned Date of Completion') }}
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
                                {{ __('Notification Start Date') }}
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
                                {{ __('Notification Interval (in days)') }}
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
                            {{ __('Your Notes') }}
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

                    <button type="submit"
                        class="text-white mt-1 bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        {{ __('Update') }}
                    </button>
                </form>

            </div>

            <div class="relative overflow-x-auto p-5 mt-4 bg-white">
                <form action="{{route('tasks.followers.update')}}" method="POST">
                    @csrf
                    <input type="text" name="task_id" id="" value="{{ $task->id }}" hidden />
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="followers" class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Assign Followers (*Notes are not assigned on only updating followers)') }}
                        </label>
                        <div class="relative">
                            <input type="text" id="follower-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Search users...">
                            <div id="follower-results"
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-60 overflow-auto">
                            </div>
                        </div>
                        <div id="selected-followers" class="mt-2 flex flex-wrap gap-2">
                            @foreach ($task->followers as $follower)
                                <div
                                    class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded flex items-center">
                                    <a href="{{ route('users.show', $follower) }}"
                                        class="ml-1 text-blue-400 hover:text-blue-600">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                    {{ $follower->name }}
                                    <button type="button" data-id="{{ $follower->id }}"
                                        class="ml-1 text-blue-400 hover:text-blue-600">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="followers" id="selected-followers-input"
                            value="{{ $task->followers->pluck('id')->toJson() }}">
                    </div>

                    <button type="submit"
                        class="text-white mt-1 bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        {{ __('Update Followers') }}
                    </button>
                </form>
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


    @push('modals')
        <script>
            // here all JS goes
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('follower-search');
                const resultsContainer = document.getElementById('follower-results');
                const selectedFollowersContainer = document.getElementById('selected-followers');
                const hiddenInput = document.getElementById('selected-followers-input');
                let selectedUsers = @json($task->followers);
                console.log(selectedUsers);

                // Fetch users when typing
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.trim();
                    console.log(query);

                    if (query.length < 2) {
                        resultsContainer.classList.add('hidden');
                        return;
                    }

                    fetch(`/api/users/search/${query}`)
                        .then(response => response.json())
                        .then(users => {
                            if (users.length > 0) {
                                resultsContainer.innerHTML = '';
                                users.forEach(user => {
                                    const userElement = document.createElement('div');
                                    userElement.className =
                                        'p-2 hover:bg-gray-100 cursor-pointer flex items-center';
                                    userElement.innerHTML = `
                                        <img src="${user.avatar || 'https://ui-avatars.com/api/?name=' + user.name}" class="w-8 h-8 rounded-full mr-2">
                                        <span>${user.name} (${user.email})</span>
                                    `;
                                    userElement.addEventListener('click', () => {
                                        if (!selectedUsers.some(u => u.id === user.id)) {
                                            selectedUsers.push(user);
                                            updateSelectedFollowers();
                                        }
                                        searchInput.value = '';
                                        resultsContainer.classList.add('hidden');
                                    });
                                    resultsContainer.appendChild(userElement);
                                });
                                resultsContainer.classList.remove('hidden');
                            } else {
                                resultsContainer.innerHTML =
                                    '<div class="p-2 text-gray-500">No users found</div>';
                                resultsContainer.classList.remove('hidden');
                            }
                        });
                });

                // Hide results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                        resultsContainer.classList.add('hidden');
                    }
                });

                function updateSelectedFollowers() {
                    selectedFollowersContainer.innerHTML = '';
                    selectedUsers.forEach(user => {
                        const tag = document.createElement('div');
                        tag.className =
                            'bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded flex items-center';
                        tag.innerHTML = `
                            ${user.name}
                            <button type="button" data-id="${user.id}" class="ml-1 text-blue-400 hover:text-blue-600">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        `;
                        selectedFollowersContainer.appendChild(tag);
                    });
                    hiddenInput.value = JSON.stringify(selectedUsers.map(u => u.id));
                }

                // Remove selected user
                selectedFollowersContainer.addEventListener('click', function(e) {
                    if (e.target.closest('button')) {
                        const userId = parseInt(e.target.closest('button').getAttribute('data-id'));
                        selectedUsers = selectedUsers.filter(u => u.id !== userId);
                        updateSelectedFollowers();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
