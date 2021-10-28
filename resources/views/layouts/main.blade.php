<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    {{-- CSS --}}
    <link rel="stylesheet" href="/css/main.css">
</head>

<body>
    @include('components.navbar', ['data' => $data = App\Models\category_institute::all(),'qtd_msg'=>$qtd_msg =
    App\Models\entradaMensagem::where('id_recebeu','=',Auth::id())->count()])

    <main>
        @if (session('msg'))
            {{-- Mensagem --}}
            <div class="flash-message p-3 border border-success">
                <p>{{ session('msg') }} <ion-icon name="checkmark-done" class="text-success"></ion-icon>
                </p>
            </div>
        @endif
        @yield('conteudo')
    </main>

    @include('components.footer')
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>
