@props(['task' => null, 'isEdit' => false])

<form method="POST" class="mb-2" action="{{ $isEdit ? route('tasks.update', $task) : route('tasks.store') }}">
    @csrf
    @if ($isEdit)
        @method('PATCH')
    @endif

    <div class="grid gap-6">

        <x-form.input name="title" id="title" label="Title" type="text" :value="old('title', $task->title ?? '')" :editable="$isEdit" required />
        <x-form.input name="description" id="description" label="Description" type="text" :value="old('description', $task->description ?? '')" :editable="$isEdit" required />

        <x-form.input name="date_of_completion" id="assigned_completion_date" label="Assigned Completion Date"
            :editable="$isEdit"
            type="datetime-local" :value="old(
                'date_of_completion',
                isset($task->assigned_date) ? \Carbon\Carbon::parse($task->assigned_date)->format('Y-m-d\TH:i') : '',
            )" required />

        <x-form.input name="notification_start_date" id="notification_start_date" label="Notification Start Date"
            type="datetime-local" :value="old(
                'notification_start_date',
                isset($task->notification_start_date)
                    ? \Carbon\Carbon::parse($task->notification_start_date)->format('Y-m-d\TH:i')
                    : '',
            )" required />

        <x-form.input name="notification_interval" id="notification_interval" label="Notification Interval" type="number"
            :value="old('notification_interval', $task->notification_interval ?? '')" required :editable="$isEdit" />

        {{-- Notes (only on Edit) --}}
        @if ($isEdit!="false")
            <div>
                <label for="notes" class="block mb-2 text-sm font-medium text-gray-900">
                    Your Notes
                </label>
                <textarea id="notes" rows="4" name="notes"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Write your reason for the task update...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- Submit --}}
        <div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                {{ $isEdit ? 'Update' : 'Create' }}
            </button>
        </div>
    </div>
</form>
