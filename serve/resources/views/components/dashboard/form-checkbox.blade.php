@props([
    'isCheck' => null,
    'target' => null
])

<input type="checkbox" id="{{ $target }}" {{ $attributes }} @checked($isCheck) 
    @disabled(
        Auth::user()->hasPermission('admin')
        && !Auth::user()->hasPermission('super-admin')
    )
>