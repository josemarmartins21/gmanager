@use('Illuminate\Support\Str')

<div class="py-3 md:w-[800px]">
    <h2 class="text-2xl font-bold dark:text-white">Permissões</h2>
    
    <div class="flex gap-2 flex-wrap">
        @foreach($permissions as $permission)
            <div class="flex gap-2">
                <x-input-label for="{{ $permission->name }}" :value="__(ucfirst(str_replace(':', ' ', $permission->name)))" />

                <x-input-checkbox id="{{ $permission->name }}" :checked="Str::contains($permission->name, 'read')" :value="$permission->name" />

                <x-input-error :messages="$errors->get('permissions[]')" class="mt-2" />   
            </div>
        @endforeach
    </div>
</div>