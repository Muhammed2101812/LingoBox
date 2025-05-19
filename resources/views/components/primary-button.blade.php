<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-custom-green text-white font-medium rounded-md shadow-sm hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-custom-green focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
