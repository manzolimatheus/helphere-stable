<header class="bg-white">
    <div class="container">
        <div class="container d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <a href="/"><img src="/img/assets/Logo.png" alt="Logo" width="80px"></a>
            </div>
        </div>
        @auth
            <form class="d-flex" action="/pesquisa" method="GET">
                <div class="input-group">
                    <span class="input-group-text" id="busca">
                        <ion-icon name="search-outline"></ion-icon>
                    </span>
                    <input class="form-control" type="search" placeholder="Faça uma pesquisa" aria-label="Search" name="q"
                        aria-describedby="busca" required>
                </div>
            </form>
            <br>
        @endauth

    </div>
</header>
@auth
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                <ion-icon name="menu-outline" class="me-2"></ion-icon>Menu
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" style="background-color: #f0f2f5;">
            <div class="container bg-white shadow p-3 rounded mb-3">
                <div class="row">
                    <div class="col-4">
                        @if (Auth::user()->profile_photo_path == '')
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                                alt="Imagem de perfil" width="80px" style="object-fit: cover; clip-path: circle()">
                        @else
                            <img src="/storage/{{ Auth::user()->profile_photo_path }}" alt="Imagem de perfil" width="80px"
                                style="object-fit: cover; clip-path: circle()">
                        @endif
                    </div>
                    <div class="col-8">
                         <span class="text-truncate">{{ Auth::user()->name }}</span>
                        <p class="text-muted text-truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="/dashboard" class="text-primary w-100 p-3">
                            <ion-icon name="home-outline"></ion-icon>
                            <br>
                            Dashboard
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="/perfil/{{ Auth::user()->id }}" class="text-primary w-100">
                            <ion-icon name="person-circle-outline"></ion-icon>
                            <br>
                            Perfil
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="/caixa_entrada" class="text-primary w-100 position-relative">
                            <ion-icon name="mail-unread-outline"></ion-icon>
                            <br>
                            Caixa de entrada
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $qtd_msg }}
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            class="text-primary w-100">
                            <ion-icon name="albums-outline"></ion-icon>
                            <br>
                            Categorias
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($data as $dt)
                                <li>
                                    <a href="/categoria/{{ $dt->id }}" class="dropdown-item">
                                        <ion-icon name="chevron-forward-outline"></ion-icon>
                                        {{ $dt->categoria }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="/suporte" class="text-primary w-100">
                            <ion-icon name="information-circle-outline"></ion-icon>
                            <br>
                            Suporte
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="/criar_campanha" class="text-primary w-100">
                            <ion-icon name="add-circle-outline"></ion-icon>
                            <br>
                            Criar campanha
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="/criar" class="text-primary w-100">
                            <ion-icon name="add-circle-outline"></ion-icon>
                            <br>
                            Criar instituição
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="/gerenciar" class="text-primary w-100">
                            <ion-icon name="apps-outline"></ion-icon>
                            <br>
                            Gerenciar
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <a href="/config" class="text-primary w-100">
                            <ion-icon name="settings-outline"></ion-icon>
                            <br>
                            Configurações
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <div class="container bg-white shadow p-3 rounded h-100">
                        <form action="/logout" method="POST" class="text-primary w-100">
                            @csrf
                            <a href="/logout" onclick="event.preventDefault();this.closest('form').submit();">
                                <ion-icon name="log-out-outline"></ion-icon>
                                <br>
                                Sair
                            </a>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endauth
<nav class="border-bottom sticky-top">

    <div class="container-fluid bg-white p-3">

        @guest
            <div class=" d-flex justify-content-center">

                <div class="row">
                    <div class="col">

                        <a href="/" class="h3">
                            <ion-icon name="home-outline"></ion-icon>
                        </a>

                    </div>
                    <div class="col">

                        <a href="/login" class="h3">
                            <ion-icon name="log-in-outline"></ion-icon>
                        </a>

                    </div>
                    <div class="col">

                        <a href="/suporte" class="h3">
                            <ion-icon name="information-circle-outline"></ion-icon>
                        </a>

                    </div>
                </div>
            </div>
        @endguest
        {{-- Botões Auth --}}
        @auth
            <div class="d-flex justify-content-center">
                <div class="row">
                    <div class="col">

                        <a href="/dashboard" class="h3">
                            <ion-icon name="home-outline"></ion-icon>
                        </a>

                    </div>
                    <div class="col">
                        <a href="#" class="h3">
                            <ion-icon name="search-outline"></ion-icon>
                        </a>
                    </div>
                    <div class="col">

                        <a href="/perfil/{{ Auth::user()->id }}" class="h3">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </a>

                    </div>
                    <div class="col">
                        <a href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            class="h3">
                            <ion-icon name="albums-outline"></ion-icon>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach ($data as $dt)
                                <li>
                                    <a href="/categoria/{{ $dt->id }}" class="dropdown-item">
                                        <ion-icon name="chevron-forward-outline"></ion-icon>
                                        {{ $dt->categoria }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        </a>
                    </div>
                    <div class="col">
                        <a class="h3" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                            aria-controls="offcanvasExample">
                            <ion-icon name="menu-outline"></ion-icon>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endauth
    </div>
</nav>
