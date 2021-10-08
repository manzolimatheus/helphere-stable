@extends('layouts.main')

@section('titulo', $campanha->nome)

@section('conteudo')

@foreach($valorDoado as $vlr)
@endforeach


<?php

use \vendor\autoload;
use \App\Pix\config_pix;
use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//bacon qrcode
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;



// GERA O VALOR DO TXID
$aleatorio = rand(25, 25);
$hash = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz0123456789"), 0, $aleatorio);

//SUBSTITUI ACENTOS E CARACTERES ESPECIAIS
function sanitizeString($string)
{

    // matriz de entrada
    $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

    // matriz de saída
    $by   = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

    // devolver a string
    return str_replace($what, $by, $string);
}


// INSTANCIA PRINCIPAL DO PAYLOAD DO PIX
$obPayload = (new Payload)->setPixKey($campanha->pixKey)
    ->setDescription('Doando para ' . sanitizeString($campanha->nome))
    ->setMerchantName(sanitizeString($campanha->titular))
    ->setMerchantCity(sanitizeString($campanha->cidade))
    ->setAmount($vlr->valorDoado)
    ->setTxid($hash);

//CODIGO DE PAGAMENTO PIX
$payloadQrCode = $obPayload->getPayload();

//QR CODE
//$obQrCode = new QrCode($payloadQrCode);

// IMAGEM DO QRCODE
//$image = (new Output\Png)->output($obQrCode, 400);

$renderer = new ImageRenderer(
    new RendererStyle(400),
    new SvgImageBackEnd()
);
$writer = new Writer($renderer);



?>

<div class="container bg-white rounded shadow p-3 mt-3 w-100 text-center" style="height: fit-content">

    <div class="col">
        <div class="container bg-white rounded shadow p-3 mt-3 w-100 text-center" style="height: fit-content">
            <br>
            <b>
                <h1 class="text-center"><strong><i>QR CODE PIX PARA A DOAÇÃO</i></strong></h1>
            </b>
            <br>
        </div>
    </div>

    <br />
    <br />

    <br>
    <div class=" col text-center img-fluid">

        <?php
        //Exibe o QR code na tela
        echo ($writer->writeString($payloadQrCode));
        ?>
    </div>
    <br><br>

    <h4><strong>Código do Pix:</strong></h4><br>

    <div class="row">
        <div class="col-2">
            <button class="btn bg-light border" onclick="copy()">
                <ion-icon name="clipboard-outline" class="h2"></ion-icon>
            </button>
        </div>
        <div class="col-10">
            <div class="container">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="link">
                        <ion-icon name="link-outline" class="h3"></ion-icon>
                    </span>
                    <input type="text" class="form-control text-muted bg-white" readonly value="<?= $payloadQrCode ?>" aria-describedby="link" id="linkToCopy">
                </div>

            </div>
        </div>
    </div>

</div>

<div class="text-center">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo%E2%80%94pix_powered_by_Banco_Central_%28Brazil%2C_2020%29.svg/2560px-Logo%E2%80%94pix_powered_by_Banco_Central_%28Brazil%2C_2020%29.svg.png" alt="Pix" class="w-50 p-3 img-fluid">
</div>

<script>
    function copy() {
        /* Get the text field */
        var copyText = document.getElementById("linkToCopy");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        alert("Texto copiado para a área de transferência!");
    }
</script>

@endsection