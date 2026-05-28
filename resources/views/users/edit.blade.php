{{-- Admin should be able to create and add users --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="p-0 sm:p-5">
        <div class="mx-auto sm:px-6 lg:px-8 p-5">



            <x-user-form :user="$user" :isEdit="true" />


        </div>
    </div>
</x-app-layout>
