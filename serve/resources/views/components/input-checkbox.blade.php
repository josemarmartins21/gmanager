@props([
    'value' => null,
    'checked' => false,
    'disable' => false,
])

<input @checked($checked) @disabled($disable) type="checkbox" name="permissions[]" value="{{ $value }}"
 {{ $attributes->merge(['class' => 'rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm']) }}
>
