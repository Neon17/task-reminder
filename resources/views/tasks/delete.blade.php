<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reminders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">


            <div class="relative overflow-x-auto p-5 bg-white">

                <div class="edit-field-container flex flex-col gap-5">

                    <x-form.input type="text" name="title" label="Title" :value="$task->title" />

                    <x-form.input type="text" name="description" label="Description" :value="$task->description" />

                    <x-form.input type="datetime-local" name="date_of_completion" :value="$task->assigned_date" label="Assigned Date of Completion"  />

                    <x-form.input type="datetime-local" name="notification_start_date" label="Notification Start Date" :value="$task->notification_start_date" />

                    <x-form.input type="number" name="notification_interval" :value="$task->notification_interval" label="Notification Interval (in days)" />


                </div>

            </div>

            <div class="grid grid-cols-2 w-100 mt-3">
                <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <div class="notes-fields mb-3">

                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900">
                            {{__("Your Notes")}}
                        </label>
                        <textarea id="message" rows="4" name="notes" required
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Write your reason for the task deletion here..."></textarea>

                    </div>
                    <button type="submit"
                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        {{__("Delete")}}
                    </button>
                </form>
            </div>
        </div>

    </div>
    </div>
</x-app-layout>
