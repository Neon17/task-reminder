<div class="relative z-0 w-full group">
    <label for="{{ $name }}"
        class="block mb-2 text-sm font-medium text-gray-900">
        {{ $label }}
        @if ($required)
            <span class="text-red-600">*</span>
        @endif
    </label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
        placeholder="{{ $placeholder }}" @if ($required) required @endif
        @if ($editable=='false') disabled @endif
        class="w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
    @error($name)
        <div class="mt-1 flex items-center text-sm text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            {{ $message }}
        </div>
    @enderror
</div>
