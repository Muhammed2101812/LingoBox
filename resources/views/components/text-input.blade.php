@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-custom-green focus:ring-custom-green rounded-md shadow-sm']) }}>
