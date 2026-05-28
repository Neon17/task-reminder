<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Reminder: ')}}  @if ($task)  {{$task->title}} @endif
        </h2>
    </x-slot>

    <div class="py-12 pt-2">
        <div class="mx-auto sm:px-6 lg:px-8">

            <div class="session-container" style="min-height: 60px;">
                @if (session('error'))
                    <div class="alert alert-error mb-4">
                        <div
                            class="flex items-center justify-between px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button type="button" class="text-red-700 hover:text-red-900"
                                onclick="this.parentElement.parentElement.remove()">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @elseif(session('success'))
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
            </div>


            <div class="relative overflow-x-auto p-5 bg-white">
                <form class="mx-auto">

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
                        </div>


                    </div>

                    <div class="relative z-0 flex gap-3 mb-5 group">
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Created By') }}
                        </label>
                        <div class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-1.5 rounded flex items-center">
                            <img src="{{ $task->creator->avatar || 'https://ui-avatars.com/api/?name=' . $task->creator->name }}"
                                class="w-5 h-5 rounded-full mr-1">
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
                        </a>
                    </div>

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
                                        <img src="{{ $follower->avatar || 'https://ui-avatars.com/api/?name=' . $follower->name }}"
                                            class="w-5 h-5 rounded-full mr-1">
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


                    <div class="notes-fields mb-3">

                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900">
                            {{ __('Your Notes') }}
                        </label>
                        <textarea id="message" rows="4" name="notes" required
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Write your reason for the task updation here..."></textarea>
                    </div>

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
                        @endif
                        </a>
                    @endif
                </form>

            </div>


        </div>
    </div>
</x-app-layout>
