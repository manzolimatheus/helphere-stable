@extends('layouts.main')

@section('titulo', 'Login')

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
        <form method="POST" action="{{ route('login') }}" class="mt-5 mt-5">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                    autofocus />
            </div>

            <div class="mt-3">
                <x-jet-label for="password" value="{{ __('Senha') }}" />
                <x-jet-input id="password" class="form-control" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="mt-3">
                <label for="remember_me">
                    <x-jet-checkbox id="remember_me" name="remember" class="form-check-input" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Manter conectado') }}</span>
                </label>
            </div>

            <div class="container">
                <div class="row">

                    <div class="col">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                {{ __('Esqueci minha senha') }}
                            </a>
                        @endif
                    </div>
                    <div class="col">
                        <a href="{{ route('register') }}">
                            {{ __('Não tem uma conta? Cadastre-se') }}
                        </a>
                    </div>
                    <x-jet-button class="btn btn-info w-100 p-3 mt-5">
                        <b> {{ __('Log in') }}</b>
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
