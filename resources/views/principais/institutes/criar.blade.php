@extends('layouts.main')

@section('titulo', 'Criar instituição')

@section('conteudo')

    {{-- Formulário --}}
    <div class="container">


        <div class="row mt-3 mb-5">
            <div class="col-sm-4">

                <div class="container p-3 bg-white shadow rounded">
                    <h3>
                        Crie sua instituição
                    </h3>
                    <form action="/criarInstitutes" method="POST" enctype="multipart/form-data">
                        @csrf

                        <label for="cnpj" class="mt-3">CNPJ da Instituição</label>
                        <input type="text" name="cnpj" id="cnpj" class="form-control" required
                            onchange="checkCnpj(this.value)" data-mask="00.000.000/0000-00">

                        <label for="nome" class="mt-3">Nome da instituição</label>
                        <input type="text" name="nome" id="nome" class="form-control" required oninput="nome_att()">


                        <label for="categoria" class="mt-3">Categoria</label>
                        <select name="categoria" id="categoria" class="form-select">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
                            @endforeach
                        </select>

                        <label for="telefone" class="mt-3">Telefone de contato</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" required>

                        <label for="email" class="mt-3">E-mail de contato</label>
                        <input type="email" name="email" id="email" class="form-control" required>

                        <label for="logradouro" class="mt-3">Endereço do local</label>
                        <input type="text" name="logradouro" id="logradouro" class="form-control" required>

                        <div class="form-group row">

                            <div class="col-md-8">
                                <label for="municipio" class="mt-3">Cidade</label>
                                <input type="text" name="municipio" id="municipio" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label for="uf" class="mt-3">Estado</label>
                                <input type="text" name="uf" id="uf" class="form-control" required>
                            </div>
                        </div>

                        <label for="pixKey" class="mt-3">Chave Pix para doações:</label>
                        <input type="text" name="pixKey" id="pixKey" class="form-control" required>

                        <label for="titular" class="mt-3">Titular da chave Pix:</label>
                        <input type="text" name="titular" id="titular" class="form-control" required>

                        <label for="image" class="mt-3">Imagem de capa</label>
                        <input type="file" name="image" id="image" class="form-control" onchange="validateCapa()"
                            accept="image/*">

                        <label for="image_perfil" class="mt-3">Imagem de perfil:</label>
                        <input type="file" name="image_perfil" id="image_perfil" class="form-control"
                            onchange="validatePerfil()" accept="image/*">

                        <label for="descricao" class="mt-3">Descrição da instituição</label><br>
                        <textarea name="descricao" id="descricao" class="form-control" required></textarea>

                        <button type="submit"
                            class="btn bg-verde-agua w-100 text-white mt-3 rounded-pill"><b>Criar</b></button>

                    </form>
                </div>
            </div>
            <div class="col-sm-8">

                {{-- Topo perfil do usuário --}}
                <div class="container bg-white rounded shadow w-100 text-center p-3">

                    <h3>Preview da instituição</h3>
                    <hr>
                    <div class="container">
                        <img src="https://ui-avatars.com/api/?name=:)&color=7F9CF5&background=EBF4FF"
                            class="w-100 rounded-bottom" style="width: 800; height: 300px; object-fit: cover;" id="preview">
                    </div>

                    <div class="container p-3">
                        <img src="https://ui-avatars.com/api/?name=:)&color=7F9CF5&background=EBF4FF" alt="Imagem de perfil"
                            class="img-perfil rounded-circle" id="preview_img_perfil">

                        <h1 id="nome_preview">Nome da instituição</h1>
                        <p class="text-muted">Instituição</p>

                        <div class="container text-center">
                            <a href="#">
                                <ion-icon name="create-outline"></ion-icon>Editar
                            </a>
                        </div>

                    </div>
                    <div class="container p-3">
                        <hr>
                        <div class="row">
                            {{-- Coluna 1 --}}
                            <div class="col-sm p-1">
                                <button class="btn bg-verde-agua w-100 p-3 text-white rounded-pill">
                                    <b>Apoiar causa</b>
                                </button>
                            </div>
                            {{-- Coluna 2 --}}
                            <div class="col-sm p-1">
                                <button class="btn btn-info w-100 p-3 text-white rounded-pill">
                                    <b>Compartilhar</b>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Script para carregar preview da imagem de capa --}}
        <script>
            function validateCapa() {
                var fileName = document.getElementById("image").value;
                var idxDot = fileName.lastIndexOf(".") + 1;
                var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                if (extFile == "jpg" || extFile == "jpeg" || extFile == "png") {
                    var output = document.getElementById('preview');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    output.onload = function() {
                        URL.revokeObjectURL(output.src) // free memory
                    }
                } else {
                    alert("Somente imagens com extensão .jpg, .jpeg e .png são permitidas!");
                    document.getElementById("image").value = '';
                }
            }

            function validatePerfil() {
                var fileName = document.getElementById("image_perfil").value;
                var idxDot = fileName.lastIndexOf(".") + 1;
                var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
                    var output = document.getElementById('preview_img_perfil');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    output.onload = function() {
                        URL.revokeObjectURL(output.src) // free memory
                    }
                } else {
                    alert("Somente imagens com extensão .jpg, .jpeg, .png e .gif são permitidas!");
                    document.getElementById("image_perfil").value = '';
                }
            }

            function nome_att() {
                document.getElementById("nome_preview").innerText = document.getElementById('nome').value;
            }
        </script>

        {{-- Scripts da API de CNPJ --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

        <script type="text/javascript">
            function checkCnpj(cnpj) {

                $.ajax({
                        url: "https://www.receitaws.com.br/v1/cnpj/" + cnpj.replace(/[^0-9]/g, '') + "",
                        type: "GET",
                        dataType: "jsonp",

                        //JSONP ou "JSON with padding" é um complemento ao formato de dados JSON.
                        //Ele provê um método para enviar requisições de dados de um servidor para um
                        //domínio diferente, uma coisa proibida pelos navegadores típicos por causa da
                        //Política de mesma origem.

                        success: function(data) {

                            console.log(data);

                            if (data.nome == undefined) {
                                alert(data.status + ' ' + data.message);
                            } else {
                                document.getElementById('nome').value = data.nome;
                                document.getElementById('email').value = data.email;
                                document.getElementById('telefone').value = data.telefone;
                                document.getElementById('logradouro').value = data.logradouro;
                                document.getElementById('municipio').value = data.municipio;
                                document.getElementById('uf').value = data.uf;
                            }

                        }

                    }

                );
            }
        </script>

    @endsection
