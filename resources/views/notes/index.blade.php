<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            @if (auth()->user()->isAdmin())
                <h4 class="text-xl font-extrabold text-center">{{__("All Notes")}}</h4>
            @else
                <h4 class="text-xl font-extrabold text-center">{{__("Your Notes")}}</h4>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-4 mb-7">

                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    {{__("SN")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Description")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("User")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Task")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Reason")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Assigned Date")}}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    {{__("Created Date")}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($notes) == 0)
                                <tr class="bg-white border-b border-gray-200">
                                    <td class="px-6 py-4 w-100">
                                        <p class="text-center">{{__("No notes found")}}</p>
                                    </td>
                                </tr>
                            @else
                                @foreach ($notes as $note)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4 w-100">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $note->description }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $note->user->name }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            @if ($note->task)
                                                {{ $note->task->title }}
                                            @else
                                                <em>{{__("Deleted")}}</em>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            {{ $note->reason }}
                                        </td>
                                        <td class="px-6 py-4 w-100">
                                            @if ($note->task)
                                                {{ $note->task->assigned_date }}
                                            @else
                                                <em>{{__("Deleted")}}</em>
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



            @if (!auth()->user()->isAdmin())
                <h4 class="text-xl font-extrabold text-center">Followed Task Notes</h4>


                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-4 mb-7">

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-900 uppercase bg-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        SN
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Description
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        User
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Task
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Reason
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Assigned Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @if (count($followednotes) == 0)
                                    <tr class="bg-white border-b border-gray-200">
                                        <td class="px-6 py-4 w-100">
                                            <p class="text-center">No notes found</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($followednotes as $note)
                                        <tr class="bg-white border-b border-gray-200">
                                            <td class="px-6 py-4 w-100">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                {{ $note->description }}
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                {{ $note->user->name }}
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                @if ($note->task)
                                                    {{ $note->task->title }}
                                                @else
                                                    <em>Deleted</em>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                {{ $note->reason }}
                                            </td>
                                            <td class="px-6 py-4 w-100">
                                                @if ($note->task)
                                                    {{ $note->task->assigned_date }}
                                                @else
                                                    <em>Deleted</em>
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

            @endif


        </div>
    </div>
</x-app-layout>
