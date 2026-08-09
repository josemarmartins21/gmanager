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
                    <table class="w-full text-center"> 
                        <thead>
                            <tr class="text-xl">
                                <th class="py-2 border-b">Nome</th>
                                <th class="py-2 border-b">Email</th>
                                <th class="py-2 border-b">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="dark:text-zinc-300">
                                    <td class="py-2 border-b">{{ $user->name }}</td>
                                    <td class="py-2 border-b">{{ $user->email }}</td>
                                    <td class="py-2 border-b">
                                        <a href="{{ route('profile.edit', ['user' => $user]) }}" class="dark:bg-white dark:text-black px-3 py-1 rounded-md font-bold">Ver Perfil</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
