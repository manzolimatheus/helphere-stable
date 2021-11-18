@extends('layouts.main')

@section('titulo', 'Suporte')

@section('conteudo')

<div class="container d-flex justify-content-center">
    <div class="row w-100">
        <aside class="col-sm-3">
            <div class="container p-3 mt-3 rounded bg-white shadow">
                <b class="lead">Sumário</b>

                <ul>
                    <li><a href="#faq">Perguntas Frequentes</a></li>
                    <li><a href="#problemSolutions">Solução de Problemas</a></li>
                    <li><a href="#htd">Como fazer?</a></li>
                </ul>
            </div>
        </aside>
        <div class="col-sm-9">
            <div class="container p-5 mt-3 rounded bg-white shadow">

                <section id="faq">

                    
                        
                            <h2 class="mb-5"><strong>F.A.Q.</strong></h2>
                        
                        <article>

                            <h4>Por que não estou recebendo as doações por meio do PIX?</h4>
                            <details>
                                <summary></summary>
                            <p style="text-align: justify">Pode ser que algum dado referente à geração do QRCode PIX para doações, como Chave PIX, nome do titular da conta ou
                                nome da cidade esteja incorreto. Vá até a página referente à sua instituição e clique no link nomeado como "Editar",
                                confira os dados cadastrados e corrija o que estiver errado.</p>
                            </details>
                        </article>
                        <article>
                            <h4>Como faço para doar algum item ou alimento ao invés de dinheiro?</h4>
                            <details>
                                <summary></summary>
                            <p style="text-align: justify">Para isso, você deve entrar em contato com a instituição, por meio do e-mail cadastrado e agendar sua visita para realizar a
                                entrega dos itens. Você pode encontrar o e-mail da instituição, na página referente à ela, na seção "Sobre", onde estão as informações como
                                telefone, e-mail e endereço.
                            </p>
                            </details>

                        </article>
                    


                </section>
                <section id="problemSolutions">

                    
                        
                            <h2 class="mb-5"><strong>Solução de problemas</strong></h2>
                        
                        <article>
                            <h4>Código do PIX inválido, o que pode ser?</h4>
                            <details>
                                <summary></summary>
                            <p style="text-align: justify">Como dito na resposta acima, o representante, na hora de cadastrar sua instituição, acabou por digitar incorretamente algum dado referente a
                                geração do código PIX, fazendo com que o código gerado pelo site, não funcione. Caso o representante não corrija esse erro, entre em contato
                                com a instituição por meio do e-mail, e avise do erro, para que ele possa colocar os dados corretos.
                            </p>
                            </details>
                        </article>
                    
                </section>
                <section id="htd">

                    
                        
                            <h2 class="mb-5"><strong>Como fazer?</strong></h2>
                        
                        <article>
                            <h4>Como faço para cadastrar uma instituição?</h4>
                            <details>
                                <summary></summary>
                            <p style="text-align: justify">Basta clicar no botão escrito "Criar instituição", presente na pagina inicial. Após clicar no botão
                                você será redirecionado para uma outra página, onde você deverá preencher os dados necessários para a realização do
                                cadastro. Digite os dados com atenção.
                            </p>
                            </details>
                        </article>
                        <article>
                            <h4>Como me cadastro no site?</h4>
                            <details>
                                <summary></summary>
                            <p style="text-align: justify">Ao abrir o site em seu navegador, você deve clicar no botão de login. Após clicar no botão,
                                você sera enviado para uma pagina onde deve colocar seu e-mail e sua senha para logar no site, mas caso
                                não tenha sido cadastrado, logo abaixo dos campos de email e senha existe um link que te leva para uma outra página,
                                onde será feito o seu cadastro. Para isso, basta preencher os dados pedidos, e confirmar clicando no botão.
                            </p>
                            </details>
                        </article>
                        <article>
                            <h4>Como eu crio uma postagem para a comunidade?</h4>
                            <details>
                                <summary></summary>
                            <p style="text-align: justify">Basta ir até o seu perfil, ou o perfil de sua Instituição, ir até o campo de postagens e escrever sua mensagem ou selecionar uma 
                                imagem, para que ela possa ser postada e compartilhada com os demais usuários
                            </p>
                            </details>
                        </article>
                        <article>
                            <h4>Como posso doar para alguma instituição?</h4>
                            <details>
                                <summary></summary>
                            <p style="text-align: justify">Na pagina da instituição escolhida, clique no botão "Apoiar causa" e uma janela se abrirá. Nessa janela você colocará o valo que deseja doar 
                                e clicar no botão "Gerar código Pix". Ao fazer isso, você será redirecionado para uma página que conté um QrCode e um codigo em texto logo abaixo.
                                Basta scanear o qrcode ou copiar o código em texto e realizar a doação.
                            </p>
                            </details>
                        </article>
                    
                </section>
            </div>
        </div>
    </div>
</div>

@endsection