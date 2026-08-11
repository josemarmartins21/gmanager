<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-4 py-2 dark:bg-white dark:text-black px-3 py-1 rounded-md font-bold border rounded-md']) }}>
    {{ $slot }}
</button>
