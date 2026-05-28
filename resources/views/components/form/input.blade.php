<div class="relative z-0 w-full group">
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
        placeholder="{{ $placeholder }}" @if ($required) required @endif
        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer">
    <label for="{{ $name }}"
        class="absolute text-sm text-gray-500 duration-300 transform scale-75 -translate-y-6 top-3 -z-10 origin-[0] transition-all peer-focus:scale-75 peer-focus:-translate-y-6
        {{ !empty($value) ? '-translate-y-6 scale-75' : 'peer-placeholder-shown:translate-y-0 peer-placeholder-shown:scale-100' }}">
        {{ $label }}
    </label>
    @error($name)
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
