@php
    $existingFollowersJson = $existingFollowers->pluck('id')->toJson();
    $followerNamesJson = $existingFollowers
        ->map(function ($follower) {
            return [$follower->id => $follower->name];
        })
        ->collapse()
        ->toJson();
@endphp

<div id="assign-followers-container">
    <input type="hidden" name="{{ $name }}" id="selected-followers-input" value="{{ $existingFollowersJson }}">

    <div>
        <label for="follower-search" class="block mb-2 text-sm font-medium text-gray-900">
            Assign Followers
        </label>

        <div class="relative">
            <input type="text" id="follower-search"
                class="w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search users..." autocomplete="off">

            <div id="follower-results"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-60 overflow-auto">
            </div>
        </div>

        <div id="selected-followers" class="mt-2 flex flex-wrap gap-2">
            @foreach ($existingFollowers as $follower)
                <div class="follower-tag bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded flex items-center"
                    data-id="{{ $follower->id }}">
                    {{ $follower->name }}
                    <button type="button" class="remove-follower ml-1 text-blue-400 hover:text-blue-600">
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
</div>

@push('modals')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store our elements
            const container = document.getElementById('assign-followers-container');
            const searchInput = document.getElementById('follower-search');
            const resultsContainer = document.getElementById('follower-results');
            const selectedContainer = document.getElementById('selected-followers');
            const hiddenInput = document.getElementById('selected-followers-input');

            // Initialize state from existing followers
            let selectedFollowers = JSON.parse(hiddenInput.value || '[]');
            let followerNames = {!! $followerNamesJson !!}.reduce((acc, curr) => {
                acc[curr.id] = curr.name;
                return acc;
            }, {});

            // Show existing followers in dropdown
            function showExistingFollowers() {
                resultsContainer.innerHTML = '';

                fetch(`/api/users`)
                    .then(res => res.json())
                    .then(users => {
                        resultsContainer.innerHTML = '';

                        if (users.length === 0) {
                            showNoResultsMessage();
                            return;
                        }

                        users.forEach(user => {
                            const el = createUserElement(user);
                            resultsContainer.appendChild(el);
                        });

                        resultsContainer.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        showNoResultsMessage();
                    });

                resultsContainer.classList.remove('hidden');
            }

            // Show no results message
            function showNoResultsMessage() {
                resultsContainer.innerHTML = `
            <div class="p-2 text-gray-500 text-sm">
                No matching users found
            </div>
        `;
                resultsContainer.classList.remove('hidden');
            }

            // Create user element for dropdown
            function createUserElement(user) {
                const el = document.createElement('div');
                el.className = 'p-2 hover:bg-gray-100 cursor-pointer flex items-center';
                el.innerHTML = `
            <img src="${user.profile_picture_path || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name)}" class="w-6 h-6 rounded-full mr-2">
            <span>${escapeHtml(user.name)}${user.email ? ` (${escapeHtml(user.email)})` : ''}</span>
        `;
                el.addEventListener('click', () => {
                    addFollower(user);
                    searchInput.value = '';
                    resultsContainer.classList.add('hidden');
                });
                return el;
            }

            searchInput.addEventListener('focus', debounce(function() {
                const query = searchInput.value.trim();
                if (query.length < 1) {
                    showExistingFollowers();
                    return;
                }
            }, 300))

            function showFilteredUsers(query) {
                fetch(`/api/users/search/${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(users => {
                        resultsContainer.innerHTML = '';

                        if (users.length === 0) {
                            showNoResultsMessage();
                            return;
                        }

                        users.forEach(user => {
                            const el = document.createElement('div');
                            el.className =
                                'p-2 hover:bg-gray-100 cursor-pointer flex items-center';
                            el.innerHTML = `
                        <img src="${user.profile_picture_path || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name)}" class="w-6 h-6 rounded-full mr-2">
                        <span>${escapeHtml(user.name)} (${escapeHtml(user.email)})</span>
                    `;
                            el.addEventListener('click', () => {
                                addFollower(user);
                                searchInput.value = '';
                                resultsContainer.classList.add('hidden');
                            });
                            resultsContainer.appendChild(el);
                        });

                        resultsContainer.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        resultsContainer.classList.add('hidden');
                    });
            }

            // Show users list
            searchInput.addEventListener('input', debounce(function() {
                const query = searchInput.value.trim();
                if (query.length == 0) {
                    showExistingFollowers();
                }
                else {
                    showFilteredUsers(query);
                }
            }, 300));

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!container.contains(e.target)) {
                    resultsContainer.classList.add('hidden');
                }
            });

            // Remove follower handler using event delegation
            selectedContainer.addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.remove-follower');
                if (removeBtn) {
                    const tag = removeBtn.closest('.follower-tag');
                    const id = parseInt(tag.dataset.id);
                    removeFollower(id);
                }
            });

            // Add a new follower
            function addFollower(user) {
                if (!selectedFollowers.includes(user.id)) {
                    selectedFollowers.push(user.id);
                    followerNames[user.id] = user.name;
                    updateSelectedFollowers();
                    updateHiddenInput();
                }
            }

            // Remove a follower
            function removeFollower(id) {
                selectedFollowers = selectedFollowers.filter(f => f !== id);
                updateSelectedFollowers();
                updateHiddenInput();
            }

            // Update the visible tags
            function updateSelectedFollowers() {
                selectedContainer.innerHTML = '';
                selectedFollowers.forEach(id => {
                    const tag = document.createElement('div');
                    tag.className =
                        'follower-tag bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded flex items-center';
                    tag.dataset.id = id;
                    tag.innerHTML = `
                ${escapeHtml(followerNames[id] || 'Loading...')}
                <button type="button" class="remove-follower ml-1 text-blue-400 hover:text-blue-600">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
                    selectedContainer.appendChild(tag);
                });
            }

            // Update the hidden input value
            function updateHiddenInput() {
                hiddenInput.value = JSON.stringify(selectedFollowers);
                // console.log('Updated hidden input value:', hiddenInput.value); // For debugging
            }

            // Simple debounce function
            function debounce(func, timeout = 300) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    timer = setTimeout(() => {
                        func.apply(this, args);
                    }, timeout);
                };
            }

            // Basic HTML escaping
            function escapeHtml(unsafe) {
                return unsafe
                    .toString()
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }
        });
    </script>
@endpush
