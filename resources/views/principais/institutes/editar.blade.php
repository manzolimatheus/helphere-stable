@extends('layouts.main')

@section('titulo', 'Edição de instituição | HelpHere')

@section('conteudo')

<div class="container">


    {{-- Formulário --}}
    <div class="container">

        {{-- Título --}}

        <div class="row mt-3 mb-5">
            <div class="col-sm-4">
                <div class="container p-3 bg-white shadow rounded">

                    <h3>
                        Editando
                        {{ $institute->nome_instituicao }}
                    </h3>
                    <form action="/instituicao/update/{{ $institute->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <label for="cnpj" class="mt-3">CNPJ da Instituição</label>
                        <input type="text" name="cnpj" id="cnpj" class="form-control" required data-mask="00.000.000/0000-00" value="{{ $institute->cnpj }}">

                        <label for="nome" class="mt-3">Nome da instituição</label>
                        <input type="text" name="nome_instituicao" id="nome" value="{{ $institute->nome_instituicao }}" class="form-control" oninput="nome_att()">

                        <label for="categoria" class="mt-3">Categoria</label>
                        <select name="id_categoria" id="categoria" class="form-select">
                            @foreach ($categorias as $categoria)
                            @if ($institute->id_categoria == $categoria->id)
                            <option value="{{ $categoria->id }}" selected>{{ $categoria->categoria }}
                            </option>
                            @else
                            <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
                            @endif
                            @endforeach
                        </select>


                        <label for="tel" class="mt-3">Telefone de contato:</label>
                        <input type="tel" name="telefone" id="tel" value="{{ $institute->telefone }}" class="form-control">


                        <label for="tel" class="mt-3">E-mail de contato:</label>
                        <input type="email" name="email" id="email" value="{{ $institute->email }}" class="form-control">


                        <div class="form-group row">

                            <div class="col-md-8">
                                <label for="municipio" class="mt-3">Cidade</label>
                                <input type="text" name="municipio" id="municipio" value="{{ $institute->municipio }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="uf" class="mt-3">Estado</label>
                                <input type="text" name="uf" id="uf" value="{{ $institute->uf }}" class="form-control">
                            </div>
                        </div>

                        <label for="pixKey" class="mt-3">Chave Pix para doações:</label>
                        <input type="text" name="pixKey" id="pixKey" class="form-control" value="{{$institute->pixKey}}" required>

                        <label for="titular" class="mt-3">Titular da chave Pix:</label>
                        <input type="text" name="titular" id="titular" class="form-control" value="{{$institute->titular}}" required>

                        <label for="tel" class="mt-3">Endereço do local:</label>
                        <input type="text" name="logradouro" id="logradouro" value="{{ $institute->logradouro }}" class="form-control">

                        <label for="image" class="mt-3">Imagem de capa:</label>
                        <input type="file" name="image" id="image" onchange="validateCapa()" class="form-control" accept="image/*">

                        <label for="image_perfil" class="mt-3">Imagem de perfil:</label>
                        <input type="file" name="image_perfil" id="image_perfil" onchange="validatePerfil()" class="form-control" accept="image/*">

                        <label for="descricao" class="mt-3">Descrição da instituição:</label><br>
                        <textarea name="descricao" id="descricao" class="form-control">{{ $institute->descricao }}</textarea>

                        <button type="submit" class="btn bg-verde-agua w-100 text-white mt-3 rounded-pill"><b>Salvar</b></button>

                    </form>
                </div>

            </div>


            <div class="col-sm-8">

                {{-- Topo perfil do usuário --}}
                <div class="container bg-white rounded shadow w-100 text-center p-3">

                    <h3>Preview da instituição</h3>
                    <hr>
                    <div class="container">
                        <img src="{{ $institute->image }}" class="w-100 rounded-bottom" style="width: 800; height: 300px; object-fit: cover;" id="preview">
                    </div>

                    <div class="container p-3">
                        <img src="{{ $institute->image_perfil }}" alt="Imagem de perfil" class="img-perfil rounded-circle" id="preview_img_perfil">

                        <h1 id="nome_preview">{{$institute->nome_instituicao}}</h1>
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

    @endsection