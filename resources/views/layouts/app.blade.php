@extends('layouts.main')
@section('titulo', 'Configurações')
<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

<!-- Styles -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}">

@livewireStyles
@section('conteudo')


<!-- Page Content -->
<main>
    {{ $slot }}
</main>


@stack('modals')

@livewireScripts
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
</head>
@endsection
