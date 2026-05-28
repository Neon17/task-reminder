<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminder: ') }} @if ($task)
                {{ $task->title }}
            @endif
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="mx-auto sm:px-6 lg:px-8">

            <x-session-message />

            <div class="buttons my-3 flex justify-end">
                @if ($task->canComplete())
                    <a type="button" href="{{ route('tasks.complete', $task) }}"
                        class="text-white bg-gray-600 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        {{ __('Complete Task') }}
                    </a>
                @endif
            </div>

            <div class="relative overflow-x-auto p-5 my-2 bg-white">
                @include('tasks._form', ['task' => $task, 'isEdit' => "true"])                
            </div>
            
            <div class="relative overflow-x-auto p-5 my-2 bg-white">
                @include('tasks._followers', ['task' => $task])
            </div>
            
            @if (count($notes) > 0)            
                <div class="relative overflow-x-auto p-5 my-2 bg-white">
                    @include('tasks._notes', ['notes' => $notes])
                </div>
            @endif
            
        </div>
    </div>

</x-app-layout>
