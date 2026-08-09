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
            @foreach ($permissions as $permission)
              <tr class="dark:text-zinc-300">
                    <x-app.table-data>{{ $permission->name }}</x-app.table-data>
                    <x-app.table-data>
                        <form action="" method="post">
                            <x-primary-button>{{ __('Desassociar') }}</x-primary-button>  
                        </form>
                    </x-app.table-data>
                </tr>
            @endforeach
        </tbody>
    </x-app.table>

    <a href="#" class="dark:bg-white dark:text-black px-3 py-1 rounded-md font-bold">
        Adicionar Permissão
    </a>
</section>
