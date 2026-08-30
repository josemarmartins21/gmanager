@use('Illuminate\Support\Facades\Auth')
@use('App\Helpers\DateHelper')
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('images/icones/qos-logo-sem-fundo.png') }}" type="image/x-icon">


    @vite(['resources/css/app.css', 'resources/js/app.js'])    

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body id="corpo">
    <header>
        <div id="logo">
            <a href="{{ route('home') }}"><x-application-logo /></a>
            
            <div id="barra-divisao"></div>

            <h1 class="text-5xl font-bold">@yield('section')</h1>
        </div>

        <div id="data-actual">
            <p>{{ DateHelper::currentExtendedDate() }}</p>
        </div>

        <div id="menu-container">
            <span id="menu"><i class="fa-solid fa-bars text-xl"></i></span>
        </div>
    </header>
    <main class="principal-container">
        <section id="side-bar" class="hidden lg:flex">
            <nav>
                <x-dashboard.link-nav-container>
                    <x-dashboard.link-nav href="{{ route('home') }}"
                        :active="request()->routeIs('home')"
                    >
                        <i class="fa-solid fa-house"></i> Home
                    </x-dashboard.link-nav>
                    <x-dashboard.link-nav 
                        href="{{ route('sales.index') }}"
                        :active="request()->routeIs('sales.index') || request()->routeIs('sales.create') || request()->routeIs('sales.edit')" 
                    >
                        <i class="fa-solid fa-house-signal"></i>
                        Vendas
                    </x-dashboard.link-nav>
                    <x-dashboard.link-nav 
                        href="{{ route('products.index') }}"
                        :active="request()->routeIs('products.index') || request()->routeIs('products.create') || request()->routeIs('products.edit') || request()->routeIs('products.show') || request()->routeIs('join.contact')" 
                    >
                        <i class="fa-solid fa-circle-user"></i>
                        Productos
                    </x-dashboard.link-nav>
                    <x-dashboard.link-nav 
                        href="{{ route('stock-movements.index') }}"
                        :active="request()->routeIs('stock-movements.index') || request()->routeIs('stock-movements.create') || request()->routeIs('stock-movements.edit')"
                    >
                        <i class="fa-solid fa-people-group"></i> Movimentações de Estoque
                    </x-dashboard.link-nav>
{{--                     @can ('super-admin') 
                        <x-dashboard.link-nav 
                        href="{{ route('users.index') }}"
                        :active="request()->routeIs('users.index') || request()->routeIs('users.create')
                        || request()->routeIs('users.edit') || request()->routeIs('users.show')
                        "
                        >
                            <i class="fa-solid fa-users"></i> Gerir Usuários
                    </x-dashboard.link-nav>
                    @endcan
                    @can ('admin') 
                        <x-dashboard.link-nav 
                        href="{{ route('users.index') }}"
                        :active="request()->routeIs('users.index') || request()->routeIs('register')
                        || request()->routeIs('users.edit') || request()->routeIs('users.show')
                        "
                        >
                            <i class="fa-solid fa-user-gear"></i> Gerir Usuários
                    </x-dashboard.link-nav>
                    @endcan --}}
                {{-- <x-dashboard.link-nav 
                    href="{{ route('settings') }}"
                    :active="request()->routeIs('settings')"
                >
                    <i class="fa-solid fa-gear"></i>  Definições
                </x-dashboard.link-nav> --}}
                </x-dashboard.link-nav-container>
            </nav>
        
            <div id="logout-btn">
                
                <form action="{{ route('logout') }}" method="POST">
                    <button 
                        type="submit" 
                        onclick="return confirm('Tem a certeza que deseja terminar a sessão?')"
                        class="text-4xl"    
                    >
                        @csrf

                        <i class="fa-solid fa-right-from-bracket"></i>  Sair
                    </button>
                </form>
            </div>
    </section>
    <section id="principal">
        @yield('content')
    </section>    
    </main>
    <script src="{{ asset('js/script.js') }}"></script>      
</body>
</html>