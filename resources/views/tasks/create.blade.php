<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Reminder') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">

            <div class="relative overflow-x-auto p-5 my-2 bg-white">
                @include('tasks._form', ['task' => null, 'isEdit' => "false"])
            </div>

            <div class="relative p-5 my-2 bg-white">
                @include('tasks._followers')
            </div>

        </div>
    </div>

</x-app-layout>
