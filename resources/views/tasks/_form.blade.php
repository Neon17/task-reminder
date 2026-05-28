@props(['task' => null, 'isEdit' => false])

<form method="POST" class="mb-2" action="{{ $isEdit ? route('tasks.update', $task) : route('tasks.store') }}">
    @csrf
    @if($isEdit) @method('PATCH') @endif

    <div class="grid gap-6">

        {{-- Title --}}
        <div class="relative z-0 w-full group">
            <input type="text" name="title" id="title"
                value="{{ old('title', $task->title ?? '') }}"
                placeholder=" " required
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            <label for="title"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Title
            </label>
            @error('title')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="relative z-0 w-full group">
            <input type="text" name="description" id="description"
                value="{{ old('description', $task->description ?? '') }}"
                placeholder=" " required
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            <label for="description"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Description
            </label>
            @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Assigned Completion Date --}}
        <div class="relative z-0 w-full group">
            <input type="datetime-local" name="date_of_completion" id="date_of_completion"
                value="{{ old('date_of_completion', isset($task->assigned_date) ? \Carbon\Carbon::parse($task->assigned_date)->format('Y-m-d\TH:i') : '') }}"
                placeholder=" " required
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            <label for="date_of_completion"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Assigned Date of Completion
            </label>
            @error('date_of_completion')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Notification Start Date --}}
        <div class="relative z-0 w-full group">
            <input type="datetime-local" name="notification_start_date" id="notification_start_date"
                value="{{ old('notification_start_date', isset($task->notification_start_date) ? \Carbon\Carbon::parse($task->notification_start_date)->format('Y-m-d\TH:i') : '') }}"
                placeholder=" " required
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            <label for="notification_start_date"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Notification Start Date
            </label>
            @error('notification_start_date')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Notification Interval --}}
        <div class="relative z-0 w-full group">
            <input type="number" name="notification_interval" id="notification_interval"
                value="{{ old('notification_interval', $task->notification_interval ?? '') }}"
                placeholder=" " required
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            <label for="notification_interval"
                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                Notification Interval (in days)
            </label>
            @error('notification_interval')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Notes (only on Edit) --}}
        @if($isEdit)
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
