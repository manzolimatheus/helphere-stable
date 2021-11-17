<footer class="bg-light pt-5">
    <div class="container d-flex justify-content-center">
        <br>
        <hr>
        <div class="row p-5 w-100">
            <div class="col-sm">
                {{-- O que é o Help here --}}
                <div class="container">
                    <b class="lead">O que é o Helphere?</b>
                    <br>
                    <img src="/img/assets/Logo.png" alt="Logo HelpHere" width="100">
                    <br>
                    <p>
                        HelpHere é uma plataforma web que busca conectar comunidades
                        e usuários, gerando assim uma corrente do bem que beneficia
                        a todos e aquece corações!
                    </p>
                </div>
            </div>
            {{-- Acesso fácil --}}
            <div class="col-sm">
                <div class="container">
                    <b class="lead">Acesso fácil</b>
                    <br><br>
                    <p>
                        <a href="/" class="text-dark">
                            <ion-icon name="home-outline" class="mx-2"></ion-icon>Início
                        </a>
                    </p>

                    <p>
                        <a href="/suporte" class="text-dark">
                            <ion-icon name="information-circle-outline" class="mx-2"></ion-icon>Suporte
                        </a>
                    </p>

                    @auth
                        <p>
                            <a href="/categoria/1" class="text-dark">
                                <ion-icon name="albums-outline" class="mx-2"></ion-icon>Categorias
                            </a>
                        </p>
                        <p>
                            <a href="/dashboard" class="text-dark">
                                <ion-icon name="apps-outline" class="mx-2"></ion-icon>Dashboard
                            </a>
                        </p>
                        <p>
                            <a href="/config" class="text-dark">
                                <ion-icon name="settings-outline" class="mx-2"></ion-icon>Configurações
                            </a>
                        </p>
                        <p>
                            <a href="/perfil/{{ Auth::id() }}" class="text-dark">
                                <ion-icon name="person-circle-outline" class="mx-2"></ion-icon>Perfil
                            </a>
                        </p>
                    @endauth

                    <p>
                        <a href="/arquivos/Politica_Privacidade.pdf" download="Politica_Privacidade.pdf" class="text-dark">
                            <ion-icon name="document-text-outline" class="mx-2"></ion-icon>Política de privacidade
                        </a>
                    </p>
                    <p>
                        <a href="/arquivos/Termos_e_condicoes_de_uso_para_o_site_-Help_Here.pdf" download="Termos_e_condicoes_de_uso_para_o_site_-Help_Here.pdf" class="text-dark">
                            <ion-icon name="document-text-outline" class="mx-2"></ion-icon>Termos de uso
                        </a>
                    </p>
                </div>
            </div>
            {{-- Contato --}}
            <div class="col-sm">
                <div class="container">
                    <b class="lead">Contato</b>
                    <br><br>
                    <p>
                        <a href="#" class="text-dark">
                            <ion-icon name="logo-facebook" class="mx-2"></ion-icon>Facebook
                        </a>
                    </p>
                    <p>
                        <a href="#" class="text-dark">
                            <ion-icon name="logo-instagram" class="mx-2"></ion-icon>Instagram
                        </a>
                    </p>
                    <p>
                        <a href="#" class="text-dark">
                            <ion-icon name="logo-twitter" class="mx-2"></ion-icon>Twitter
                        </a>
                    </p>
                    <p>
                        <a href="mailto: helphere.contato@gmail.com" class="text-dark">
                            <ion-icon name="mail-outline" class="mx-2"></ion-icon>E-mail
                        </a>
                    </p>
                    </ul>
                </div>
            </div>
        </div>
</footer>
<div class="container-fluid text-center text-white bg-dark p-2">
    <p>Helphere - 2021</p>
</div>
