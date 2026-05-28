@props(['task' => null])

@php
    $existingFollowers = $task?->followers ?? collect();
@endphp

<form action="{{ route('tasks.followers.update') }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="task_id" value="{{ $task?->id }}">
    <input type="hidden" name="followers" id="selected-followers-input" value="{{ old('followers', $existingFollowers->pluck('id')->toJson()) }}">

    <div>
        <label for="follower-search" class="block mb-2 text-sm font-medium text-gray-900">
            Assign Followers
        </label>

        <div class="relative">
            <input type="text" id="follower-search"
                class="w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search users...">
            <div id="follower-results"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-60 overflow-auto">
            </div>
        </div>

        <div id="selected-followers" class="mt-2 flex flex-wrap gap-2">
            @foreach ($existingFollowers as $follower)
                <div class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded flex items-center">
                    {{ $follower->name }}
                    <button type="button" data-id="{{ $follower->id }}" class="ml-1 text-blue-400 hover:text-blue-600">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    @if ($task && $task->id)
        <button type="submit"
            class="px-5 py-2.5 text-white bg-blue-700 hover:bg-blue-900 rounded-lg text-sm font-medium">
            Update Followers
        </button>
    @endif
</form>

@push('modals')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('follower-search');
        const resultsContainer = document.getElementById('follower-results');
        const selectedFollowersContainer = document.getElementById('selected-followers');
        const hiddenInput = document.getElementById('selected-followers-input');
        let selectedUsers = @json($existingFollowers);

        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length < 2) return resultsContainer.classList.add('hidden');

            fetch(`/api/users/search/${query}`)
                .then(res => res.json())
                .then(users => {
                    resultsContainer.innerHTML = ''; // Remove old results

                    if (!users.length) {
                        resultsContainer.classList.add('hidden');
                        return;
                    }

                    users.forEach(user => {
                        const el = document.createElement('div');
                        el.className = 'p-2 hover:bg-gray-100 cursor-pointer flex items-center';
                        el.innerHTML = `
                            <img src="${user.avatar || 'https://ui-avatars.com/api/?name=' + user.name}" class="w-6 h-6 rounded-full mr-2">
                            <span>${user.name} (${user.email})</span>
                        `;
                        el.onclick = () => {
                            if (!selectedUsers.some(u => u.id === user.id)) {
                                selectedUsers.push(user);
                                updateSelected();
                            }
                            searchInput.value = '';
                            resultsContainer.classList.add('hidden');
                        };
                        resultsContainer.appendChild(el);
                    });
                    resultsContainer.classList.remove('hidden');
                });
        });

        function updateSelected() {
            selectedFollowersContainer.innerHTML = '';
            selectedUsers.forEach(user => {
                const tag = document.createElement('div');
                tag.className = 'bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded flex items-center';
                tag.innerHTML = `
                    ${user.name}
                    <button type="button" data-id="${user.id}" class="ml-1 text-blue-400 hover:text-blue-600">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;
                selectedFollowersContainer.appendChild(tag);
            });
            hiddenInput.value = JSON.stringify(selectedUsers.map(u => u.id));
        }

        selectedFollowersContainer.addEventListener('click', function (e) {
            if (e.target.closest('button')) {
                const userId = parseInt(e.target.closest('button').dataset.id);
                selectedUsers = selectedUsers.filter(u => u.id !== userId);
                updateSelected();
            }
        });
    });
</script>
@endpush
