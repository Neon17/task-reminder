<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Reminder: ')}}  @if ($task)  {{$task->title}} @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">

            <x-session-message />

            <div class="relative overflow-x-auto p-5 bg-white">
                <form class="mx-auto" action="{{ route('tasks.complete', $task) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="notes-fields">

                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900">
                            {{__("Your Notes")}}
                        </label>
                        <textarea id="message" rows="4" name="notes" required
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Write your reason for the task completion here(in very short words)..."></textarea>
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
                        {{__("Complete Task")}}
                    </button>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
