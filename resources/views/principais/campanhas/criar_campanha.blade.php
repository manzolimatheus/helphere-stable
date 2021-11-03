@extends('layouts.main')

@section('titulo', 'Criar campanha')

@section('conteudo')

    {{-- Formulário --}}
    <div class="container">


        <div class="row mt-3 mb-5">
            <div class="col-sm-4">

                <div class="container p-3 bg-white shadow rounded">
                    <h3>
                        Crie sua campanha
                    </h3>
                    <form action="/post_campanha" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="nome" class="mt-3">Nome da campanha</label>
                        <input type="text" name="nome" id="nome" class="form-control" required oninput="nome_att()">


                        <label for="categoria" class="mt-3">Categoria</label>
                        <select name="categoria" id="categoria" class="form-select">
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
                            @endforeach
                        </select>

                        <label for="tel" class="mt-3">Telefone de contato</label>
                        <input type="tel" name="tel" maxlength="15" id="tel" class="form-control" required>

                        <label for="email" class="mt-3">E-mail de contato</label>
                        <input type="email" name="email" id="email" class="form-control" required>

                        <label for="voluntarios" class="mt-3">Precisa de voluntários?</label>
                        <input type="checkbox" name="voluntarios" id="voluntarios" onclick="AtivaEndereco()">
                        <br>

                        <div id="div_endereco" style="display: none">
                            <label for="tel" class="mt-3">Endereço do local</label>
                            <input type="text" name="endereco" id="endereco" class="form-control">
                        </div>

                        <label for="data_fim" class="mt-3">Data de fim da campanha</label>
                        <input type="date" name="data_fim" id="data_fim" required>
                        <br>

                        <label for="cidade" class="mt-3">Cidade:</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" required>

                        <label for="pixKey" class="mt-3">Chave Pix para doações:</label>
                        <input type="text" name="pixKey" id="pixKey" class="form-control" required>

                        <label for="titular" class="mt-3">Titular da chave Pix:</label>
                        <input type="text" name="titular" id="titular" class="form-control" required>

                        <label for="image" class="mt-3">Imagem de capa</label>
                        <input type="file" name="image" id="image" class="form-control" onchange="validateCapa()"
                            accept="image/*">


                        <label for="descricao" class="mt-3">Descrição da campanha</label><br>
                        <textarea name="descricao" id="descricao" class="form-control" required></textarea>

                        

                        <button type="submit"
                            class="btn bg-verde-agua w-100 text-white mt-3 rounded-pill"><b>Criar</b></button>

                    </form>
                </div>
            </div>
            <div class="col-sm-8">

                {{-- Topo perfil do usuário --}}
                <div class="container bg-white rounded shadow w-100 text-center p-3">

                    <h3>Preview da campanha</h3>
                    <hr>
                    <div class="container">
                        <img src="https://ui-avatars.com/api/?name=:)&color=7F9CF5&background=EBF4FF"
                            class="w-100 rounded-bottom" style="width: 800; height: 300px; object-fit: cover;" id="preview">
                    </div>

                    <div class="container p-3">

                        <h1 id="nome_preview">Nome da campanha</h1>
                        <p class="text-muted">Campanha</p>

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

            function AtivaEndereco() {
                const elemento = document.getElementById('div_endereco')

                if (elemento.style.display === 'none'){
                    elemento.style.display = 'block'
                }else{
                    elemento.style.display = 'none'
                }

            }

            function nome_att(){
                document.getElementById("nome_preview").innerText = document.getElementById('nome').value;
            }
        </script>

    @endsection
