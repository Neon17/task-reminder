<div class="relative z-0 w-full group">
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
        placeholder="{{ $placeholder }}" @if ($required) required @endif
        {{-- @if (!$editable) disabled @endif --}}
        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
    <label for="{{ $name }}"
        class="absolute text-sm text-gray-500 duration-300 transform scale-75 -translate-y-6 top-3 -z-10 origin-[0] transition-all peer-focus:scale-75 peer-focus:-translate-y-6
        {{ !empty($value) ? '-translate-y-6 scale-75' : 'peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100' }}">
        {{ $label }}
    </label>
    @error('title')
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
