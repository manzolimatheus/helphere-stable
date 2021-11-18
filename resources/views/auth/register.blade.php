@extends('layouts.main')

@section('titulo', 'Dashboard')

@section('conteudo')
@if (session('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
@endif



<div class="row w-100 g-0">

    <div class="col-sm container-helphere-login">
        <img src="/img/assets/Logo.png" alt="Logo Help Here" class="w-100">
    </div>

    <div class="col-sm bg-white p-5">
        <x-jet-validation-errors class="mb-4" />
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Nome') }}" />
                <x-jet-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Senha') }}" />
                <x-jet-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirmar senha') }}" />
                <x-jet-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-3">
                <p>
                    Ao criar uma conta, você concorda com a <a href="/arquivos/Politica_Privacidade.pdf" download="Politica_Privacidade.pdf">política de privacidade</a>
                    e <a href="/arquivos/Termos_e_condicoes_de_uso_para_o_site_-Help_Here.pdf" download="Termos_e_condicoes_de_uso_para_o_site_-Help_Here.pdf">termos de uso.</a>
                </p>
            </div>

            <div class="container mt-3">
                <a href="{{ route('login') }}">
                    {{ __('Já é registrado? Entrar') }}
                </a>

                <br>
                <x-jet-button class="btn btn-info w-100 mt-5 p-3">
                    {{ __('Registrar') }}
                </x-jet-button>
            </div>
        </form>
        <div class="row mt-5">
            <div class="col-sm-4">
                <img src="/img/assets/login-desenho.png" alt="Login desenho" class="w-100">
            </div>
            <div class="col-sm-8">
                <p class="mt-3">Conecte-se para poder ajudar e ser ajudado! Encontre comunidades com a qual você queira ajudar, faça do mundo um lugar melhor. 💖</p>
            </div>
        </div>
    </div>
</div>
@endsection
