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

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

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
