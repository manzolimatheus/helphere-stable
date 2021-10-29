@extends('layouts.main')

@section('titulo', $institute->nome_instituicao)

@section('conteudo')


    <div class="cow" style="height: fit-content">

        <div class="container bg-white rounded shadow p-3 mt-3 w-100 text-center" style="height: fit-content">

            {{-- Mensagem de bem-vindo --}}
            <div class="container text-center p-5">
                <div class="row">
                    <div class="col-sm">
                        <img src="/img/assets/estatisticas.jpg" alt="Gráfico" class="img-fluid">
                    </div>
                    <div class="col-sm" style="height: fit-content">
                        <h4 class="display-1">
                            <b>Olá</b>, <span class="text-info">{{ $usuario->name }}</span>!
                        </h4>
                        <br />
                        <br />
                        <br />
                        <br /> 
                        <h3>
                           <p style="color: gray;"> Confira aqui a quantidade de doações arrecadadas por </p><strong>{{ $institute->nome_instituicao }}</strong>
                        </h3>
                    </div>
                </div>
            </div>
        </div>


        <div class="container bg-white rounded shadow p-3 mt-3 w-100 text-center" style="height: fit-content">
            <div class="container ">
                <br>
                <h1><strong>Estimativa das doações <ion-icon name="stats-chart"></ion-icon></strong></h1>
                <p style="color:gray"><i><strong>Os valores aqui mostrados não são 100% precisos.</strong><i></p>
                <br />
                <br />
                <div class="row" style="height: fit-content">
                    <div class="col">
                        <div class="container bg-white rounded shadow p-3 mt-3 w-100 text-center" style="height: fit-content">
                            <b>
                                <h4><strong>Últimos 30 dias.</strong></h4>
                            </b>
                            <br>
                            <div class="text-center rounded mini-bloco w-100">

                                <h1>
                                    <strong>
                                    <span class="text-info"> R$ {{ $paymentLastMonth }}</span>
                                    </strong>

                                </h1>

                            </div>

                        </div>
                    </div>
                    <div class="col">
                        <div class="container bg-white rounded shadow p-3 mt-3 w-100 text-center" style="height: fit-content;">
                            <b>
                                <h4><strong>Último Ano.</strong></h4>
                            </b>
                            <br>
                            <div class="text-center rounded mini-bloco w-100">

                                <h1>
                                    <strong>
                                    <span class="text-info"> R$ {{ $paymentLastYear }}</span>
                                    </strong>

                                </h1>

                            </div>
                        </div>
                    </div>

                </div>
                <br />
                <br />
                <div style="height: fit-content">
                    <canvas class="bar-chart"></canvas>

                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
                    <?php

                    ?>
                    <script>
                        // Pega o a soma dos valores de cada mês para gerar o grafico
                        var janeiro = "<?php echo $janeiro; ?>";
                        var jan = parseInt(janeiro);

                        var fevereiro = "<?php echo $fevereiro; ?>";
                        var fev = parseInt(fevereiro);

                        var marco = "<?php echo $marco; ?>";
                        var mar = parseInt(marco);

                        var abril = "<?php echo $abril; ?>";
                        var abr = parseInt(abril);

                        var maio = "<?php echo $maio; ?>";
                        var mai = parseInt(maio);

                        var junho = "<?php echo $junho; ?>";
                        var jun = parseInt(jun);

                        var julho = "<?php echo $julho; ?>";
                        var jul = parseInt(julho);

                        var agosto = "<?php echo $agosto; ?>";
                        var ago = parseInt(agosto);

                        var setembro = "<?php echo $setembro; ?>";
                        var set = parseInt(setembro);

                        var outubro = "<?php echo $outubro; ?>";
                        var out = parseInt(outubro);

                        var novembro = "<?php echo $novembro; ?>";
                        var nov = parseInt(novembro);

                        var dezembro = "<?php echo $dezembro; ?>";
                        var dez = parseInt(dezembro);


                        var ctx = document.getElementsByClassName("bar-chart");

                        var chartGraph = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                                datasets: [{
                                    label: "Doações recebidas este ano",
                                    data: [jan, fev, mar, abr, mai, jun, jul, ago, set, out, nov, dez],
                                    borderWidth: 5,
                                    borderColor: 'rgba(0, 206, 209, 1)',
                                    backgroundColor: 'transparent'
                                }]
                            }
                        });
                    </script>
                    <br />
                    <br />
                    <br />
                </div>
            </div>
        </div>
    </div>


@endsection