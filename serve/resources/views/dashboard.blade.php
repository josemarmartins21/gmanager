<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-app.table> 
                        <thead>
                            <tr>
                                <x-app.table-head>Nome</x-app.table-head>
                                <x-app.table-head>Email</x-app.table-head>
                                <x-app.table-head>Ações</x-app.table-head>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="dark:hover:bg-zinc-500">
                                    <x-app.table-data>{{ $user->name }}</x-app.table-data>
                                    <x-app.table-data>{{ $user->email }}</x-app.table-data>
                                    <x-app.table-data>
                                        <a href="{{ route('profile.edit', ['user' => $user]) }}" class="dark:bg-white dark:text-black px-3 py-1 rounded-md font-bold">
                                            Ver Perfil
                                        </a>
                                    </x-app.table-data>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-app.table>
                    <div class="mt-[25px]"></div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
