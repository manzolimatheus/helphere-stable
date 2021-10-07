@extends('layouts.main')

@section('titulo', 'Suporte')

@section('conteudo')

    <div class="container d-flex justify-content-center">
        <div class="row w-100">
            <aside class="col-sm-3">
                <div class="container p-3 mt-3 rounded bg-white shadow">
                    <b class="lead">Sumário</b>

                    <ul>
                        <li>Tópico</li>
                    </ul>
                </div>
            </aside>
            <div class="col-sm-9">
                <div class="container p-5 mt-3 rounded bg-white shadow">
                    <section>
                        <h2 class="mb-5">F.A.Q.</h2>
                        <article>
                            <h3>Título</h3>
                            <p>Texto</p>
                        </article>
                    </section>
                    <section>
                        <h2 class="mb-5">Solução de problemas</h1>
                        <article>
                            <h3>Título</h2>
                                <p>Texto</p>
                        </article>
                    </section>
                    <section>
                        <h2 class="mb-5">Como fazer?</h2>
                        <article>
                            <h3>Título</h3>
                            <p>Texto</p>
                        </article>
                    </section>
                </div>
            </div>
        </div>
    </div>

@endsection
