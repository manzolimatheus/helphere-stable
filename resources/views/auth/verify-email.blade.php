@extends('layouts.main')

@section('titulo', 'Verificar Email')

@section('conteudo')

<div class="row w-100 g-0">

    <div class="col-sm container-helphere-login">
        <img src="/img/assets/Logo.png" alt="Logo Help Here" class="w-100">
    </div>

    <div class="col-sm bg-white p-5">

        <x-jet-validation-errors class="mb-4" />

    <div class="mt-5 mt-5">
                <div class="mb-4 text-sm text-gray-600 text-justify" style="text-align: justify">
            {{ __('Obrigado por se registrar! Antes de começar, você pode verificar seu endereço de email clicando no link que te enviamos? Se você não recebeu o email nós iremos alegremente te enviar outro, basta clicar no botão abaixo.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

     
        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit" class="btn btn-info w-100 mt-5">
                        {{ __('Reenviar e-mail de verificação') }}
                    </x-jet-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <div>

                    <x-jet-button type="submit" class="btn btn-info w-100 mt-5">
                         {{ __('Logout') }}
                    </x-jet-button>

                </div>

            </form>

        </div> 

    </div>

        <div class="row mt-5">
            <div class="col-sm-4">
                <img src="/img/assets/login-desenho.png" alt="Login desenho" class="w-100">
            </div>
            <div class="col-sm-8" style="text-align: justify">
                <p class="mt-3">Conecte-se para poder ajudar e ser ajudado! Encontre comunidades com a qual você queira ajudar, faça do mundo um lugar melhor. 💖</p>
            </div>
        </div>
    </div>
</div>


@endsection