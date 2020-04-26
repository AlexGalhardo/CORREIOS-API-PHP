<?php
    /* O código abaixo foi desenvolvido na vídeo aula, na qual eu ensino com usar a Api dos correios, para calcular o frete de um determinado produto
     * Video: https://www.youtube.com/watch?v=61-klmvyUvA
     * www.scriptmundo.com
     * = Este código foi atualizado (06/02/2019) , portando algumas coisas estão diferentes do video
     

    Código                Serviço
       40010     SEDEX sem contrato
       40045     SEDEX a Cobrar, sem contrato
       40126     SEDEX a Cobrar, com contrato
       40215     SEDEX 10, sem contrato
       40290     SEDEX Hoje, sem contrato
       40096     SEDEX com contrato
       40436     SEDEX com contrato
       40444     SEDEX com contrato
       40568     SEDEX com contrato
       40606     SEDEX com contrato
       41106     PAC sem contrato
 41211 / 41068   PAC com contrato
       81019     e-SEDEX, com contrato
       81027     e-SEDEX Prioritário, com contrato
       81035     e-SEDEX Express, com contrato
       81868     (Grupo 1) e-SEDEX, com contrato
       81833     (Grupo 2 ) e-SEDEX, com contrato
       81850     (Grupo 3 ) e-SEDEX, com contrato

    */


    $cep_origem = "13560290";     // Seu CEP , ou CEP da Loja
    $cep_destino = $_POST['cep']; // CEP do cliente, que irá vim via POST



    /* DADOS DO PRODUTO A SER ENVIADO */
    $peso          = 2;
    $valor         = 100;
    $tipo_do_frete = '40010'; //Sedex: 40010   |  Pac: 41106
    $altura        = 6;
    $largura       = 20;
    $comprimento   = 20;


    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
    $url .= "nCdEmpresa=";
    $url .= "&sDsSenha=";
    $url .= "&sCepOrigem=" . $cep_origem;
    $url .= "&sCepDestino=" . $cep_destino;
    $url .= "&nVlPeso=" . $peso;
    $url .= "&nVlLargura=" . $largura;
    $url .= "&nVlAltura=" . $altura;
    $url .= "&nCdFormato=1";
    $url .= "&nVlComprimento=" . $comprimento;
    $url .= "&sCdMaoProria=n";
    $url .= "&nVlValorDeclarado=" . $valor;
    $url .= "&sCdAvisoRecebimento=n";
    $url .= "&nCdServico=" . $tipo_do_frete;
    $url .= "&nVlDiametro=0";
    $url .= "&StrRetorno=xml";


    $xml = simplexml_load_file($url);

    $frete =  $xml->cServico;

    // echo "<h1>Valor PAC: R$ ".$frete->Valor."<br />Prazo: ".$frete->PrazoEntrega." dias</h1>";

    echo json_encode([
        "shipment_price" => $frete->Valor,
        "shipment_time" => $$frete->PrazoEntrega
    ]);

 ?>
