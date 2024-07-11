@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'pl-2 py-2 text-gray-700 border h-10 border-gray-300 focus-visible:outline-none focus-visible:border-blue-600 focus:border-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
