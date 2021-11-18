@extends('layouts.main')

@section('titulo', $perfil->name)

@section('conteudo')

    <div class="container mb-5">

        <div class="container bg-white rounded shadow w-100 text-center">
            {{-- Topo perfil do usuário --}}

            {{-- Imagem do perfil --}}
            <div class="container p-3">
                @if ($perfil->profile_photo_path == '')
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($perfil->name) }}&color=7F9CF5&background=EBF4FF"
                        alt="Imagem de perfil" class="img-perfil rounded-circle">
                @else
                    <img src="/storage/{{ $perfil->profile_photo_path }}" alt="Imagem de perfil"
                        class="img-perfil rounded-circle">
                @endif
            </div>

            {{-- Nome do perfil e botão de editar --}}
            <div class="p-3">
                <h1>{{ $perfil->name }}</h1>
                <p class="text-muted">Usuário</p>
                {{-- Se o id do usuário logado for igual ao do perfil, então opção de editar disponível --}}
                @if (Auth::id() == $perfil->id)
                    <div class="container">
                        <a href="/config">
                            <ion-icon name="create-outline"></ion-icon><b>Editar</b>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        {{-- Fim topo do perfil --}}


        {{-- Linha de conteudo --}}
        <div class="row">
            {{-- Coluna sobre mim --}}
            <div class="col-sm">
                {{-- Dados do perfil --}}
                <div class="container bg-white rounded shadow p-3 mt-3 w-100" style="height: fit-content">
                    <div class="container">
                        <h5>Sobre</h5>
                        <br>
                        <ion-icon name="mail" class="me-2 text-muted"></ion-icon>
                        <a href="mailto:{{ $perfil->email }}" class="text-primary">{{ $perfil->email }}</a>
                    </div>
                </div>

                {{-- Listando instituições do usuário --}}
                @if (count($institutes) > 0)
                    <div class="container bg-white rounded shadow p-3 mt-3">
                        <div class="container mb-3">
                            <h5>
                                Instituições ({{ count($institutes) }})
                            </h5>
                            <div class="row g-0 w-100">
                                @foreach ($institutes as $institute)
                                    <div class="col-6 p-1">
                                        <a href="/instituicao/{{ $institute->id }}">
                                            <div class="container w-100 img-institute-perfil rounded"
                                                style="background-image: linear-gradient(rgba(0, 0, 0, 0.200),rgba(0, 0, 0, 0.5)) , url('{{ $institute->image_perfil }}'); ">
                                                <div class="container text-center p-3 mini-instituicao-perfil">
                                                    <p class="text-white text-truncate">
                                                        <b>{{ $institute->nome_instituicao }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Listando instituições do usuário --}}
                @if (count($campanhas) > 0)
                    <div class="container bg-white rounded shadow p-3 mt-3">
                        <div class="container mb-3">
                            <h5>
                                Campanhas ({{ count($campanhas) }})
                            </h5>
                            <div class="row g-0 w-100">
                                @foreach ($campanhas as $campanha)
                                    <div class="col-6 p-1">
                                        <a href="/campanha/{{ $campanha->id }}">
                                            <div class="container w-100 img-institute-perfil rounded"
                                                style="background-image: linear-gradient(rgba(0, 0, 0, 0.200),rgba(0, 0, 0, 0.5)) , url('{{ $campanha->img_path }}'); ">
                                                <div class="container text-center p-3 mini-instituicao-perfil">
                                                    <p class="text-white text-truncate">
                                                        <b>{{ $campanha->nome }}</b>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            {{-- Coluna de postagens --}}
            <div class="col-sm">
                @if (Auth::id() == $perfil->id)
                    <div class="container bg-white shadow p-3 mt-3 rounded">
                        {{-- Formulário --}}
                        <form class="mb-3" action="/post_user" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="text">Mensagem</label>
                            <textarea name="data" id="text" class="form-control" required
                                placeholder="O que você deseja compartilhar com a comunidade?"></textarea>
                            <div class="row mt-3">
                                <label for="image">
                                    <ion-icon name="image-outline" class="text-success me-2"></ion-icon>Enviar imagem
                                </label>
                                <div class="col-sm mt-1">
                                    <input type="file" name="image" id="image" class="form-control w-100 rounded-pill"
                                        accept="image/*" onchange="validateImage()">
                                </div>
                                <div class="col-sm mt-1">
                                    <button type="submit" class="btn btn-success w-100 rounded-pill">
                                        <ion-icon name="send"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <img src="" id="preview" class="img-fluid rounded border shadow" width="100px">
                    </div>
                @endif
                <div class="container bg-white rounded shadow p-3 mt-3">
                    {{-- Posts --}}
                    <h5>Postagens de {{ $perfil->name }}</h5>
                </div>
                @if (count($posts) < 1)
                    <div class="container bg-white rounded shadow p-3 mt-3 mb-3">
                        <div class="container text-center">
                            <h5 class="mt-3">Esse perfil não apresenta nenhuma postagem! :(</h5>
                            <div class="container p-3 mt-3 mb-3">
                                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_ydo1amjm.json"
                                    background="transparent" speed="1" loop autoplay></lottie-player>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($posts as $post)
                        <div class="container bg-white rounded shadow p-3 mt-3 mb-3">
                            <div class="post-foto">
                                @if ($perfil->profile_photo_path == '')
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($perfil->name) }}&color=7F9CF5&background=EBF4FF"
                                        alt="Imagem de perfil">
                                @else
                                    <img src="/storage/{{ $perfil->profile_photo_path }}" alt="Imagem de perfil">
                                @endif
                                <b>{{ $perfil->name }}</b>
                            </div>
                            <div class="w-100">

                                <p>{!! nl2br(e($post->data)) !!}</p>
                                @if ($post->image != '')
                                    <img src="{{ $post->image }}" alt="Imagem" class="w-100 rounded">
                                @endif
                                <div class="row">
                                    <div class="col-sm">
                                        <p class="text-muted me-3">Postado em
                                            {{ date('d/m/Y', strtotime($post->created_at)) }}</p>
                                    </div>
                                    <div class="col-sm mb-1">
                                        @if (Auth::id() == $perfil->id)
                                            <form action="/post_user_delete/{{ $post->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-white"
                                                    onclick="return confirm('Deseja realmente deletar esse post? Essa é uma ação sem volta!');">
                                                    <span class="text-primary">Deletar post</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="col-sm">
                                        <form action="/report_post_user/{{ $post->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="border-0 bg-white"
                                                onclick="return alert('Post reportado! Nossa equipe verificará o ocorrido o mais rápido possível! 😉');">
                                                <span class="text-primary">Reportar post</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if (count($posts) > 30)
                        <div class="container bg-white rounded shadow p-3 mt-3 mb-3">
                            <div class="wrapper">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    @endif

                @endif
                {{-- Fim Posts --}}
            </div>
        </div>
    </div>

    <script>
        function validateImage() {
            var fileName = document.getElementById("image").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
                var output = document.getElementById('preview');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
            } else {
                alert("Somente imagens com extensão .jpg, .jpeg, .png e .gif são permitidas!");
                document.getElementById("image").value = '';
            }
        }
    </script>
@endsection
