<div class="py-3">
    <h2 class="text-2xl font-bold dark:text-white">Permissões</h2>
    
    <h3 class="dark:text-white text-xl font-bold pt-3">Gerente</h3>
    
    <div class="flex gap-2 flex-wrap">
        @foreach($managerPermissions as $permission)
            <div class="flex gap-2">
                <x-input-label for="{{ $permission->name }}" :value="__(ucfirst(str_replace(':', ' ', $permission->name)))" />
                <x-input-checkbox :value="$permission->name" />
            </div>
        @endforeach
    </div>
    
    <h3 class="dark:text-white text-xl font-bold pt-3">Padrão</h3>

    <div class="flex gap-2 flex-wrap">
        @foreach($defaultPermissions as $permission)
            <div class="flex gap-2">
                <x-input-label for="{{ $permission->name }}" :value="__(ucfirst(str_replace(':', ' ', $permission->name)))" />
                <x-input-checkbox :value="$permission->name" />
            </div>
        @endforeach
    </div>
</div>