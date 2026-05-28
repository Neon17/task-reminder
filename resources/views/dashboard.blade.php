<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">

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
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                <!-- Welcome Banner -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 mb-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold">{{__("Welcome back")}}, {{ Auth::user()->name }}!</h1>
                            <p class="mt-2 text-indigo-100">{{__("You have ")}}<span
                                    class="font-semibold">{{ $pendingTasksCount }}</span> {{__("pending tasks to complete")}}</p>
                        </div>
                        <div class="hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm font-medium">{{__("Pending Tasks")}}</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $pendingTasksCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm font-medium">{{__("Completed Today")}}</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $completedTodayCount }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm font-medium">{{__("Team Members")}}</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $teamMembersCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Tasks -->
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">{{__("Recent Tasks")}}</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($recentTasks as $task)
                            <div class="px-6 py-4 hover:bg-gray-50 transition duration-150">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-md font-medium text-gray-900">{{ $task->title }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $task->description }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $task->completed_date ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $task->completed_date ? 'Completed' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <p class="text-gray-500">{{__("No tasks found. Create your first task!")}}</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <a href="{{ route('tasks.index') }}"
                            class="text-indigo-600 hover:text-indigo-800 font-medium">{{__("View all tasks")}}</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
