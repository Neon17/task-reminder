{{-- Admin should be able to create and add users --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="p-0 sm:p-5">
        <div class="bg-white mx-auto sm:px-6 lg:px-8 p-5">



            @include('users.form', ['user' => $user, 'isEdit' => true])


        </div>
    </div>
</x-app-layout>
