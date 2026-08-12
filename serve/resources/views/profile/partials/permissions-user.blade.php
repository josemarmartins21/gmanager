<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Permissões do usuário') }}
        </h2>
    </header>

    <x-app.table class="mb-5"> 
        <thead>
            <tr class="text-xl">
                <x-app.table-head>Nome</x-app.table-head>
                <x-app.table-head>Ações</x-app.table-head>
            </tr>
        </thead>
        <tbody>
            @foreach ($ownPermissions as $permission)
              <tr class="dark:text-zinc-300">
                    <x-app.table-data>{{ $permission->name }}</x-app.table-data>
                    <x-app.table-data>
                        <form action="{{ route('permission.revoke', ['user' => $user->id]) }}" method="post">
                            @csrf
                            
                            <input type="hidden" name="permission" value="{{ $permission->name }}">

                            <x-primary-button onclick="return confirm('Tem a certeza que deseja desassiar o usuário da permissão?')">{{ __('Desassociar') }}</x-primary-button>  
                        </form>
                    </x-app.table-data>
                </tr>
            @endforeach
        </tbody>
    </x-app.table>

    <x-primary-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'give-permission')">
        Dar permissão
    </x-primary-button>

    <x-modal name="give-permission" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form action="{{ route('permission.give', ['user' => $user->id]) }}" method="POST">
            @csrf


            <h2 class="text-lg p-3 font-medium text-gray-900 dark:text-gray-100">
                Atribua uma permissão a {{ $user->name }}
            </h2>

            <div class="mt-6">
                <x-input-label for="permission" value="{{ __('Permissão') }}" class="sr-only" />

                <x-select-input
                    id="permission"
                    name="permission"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Criar produto') }}"
                >
                    <option value="">Selecione a permissão</option>
                    @foreach ($permissions as $permission)
                        <option value="{{ $permission->name }}" @disabled($user->can($permission->name))>
                            {{ $permission->name }}
                        </option>
                    @endforeach
                </x-select-input>

            </div>

            <div class="mt-6 flex justify-end gap-5">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button>Adicionar</x-primary-button>
            </div>
        </form>
    </x-modal>
</section>
