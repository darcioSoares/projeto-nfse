<?php


// require_once('assinarXml.php');
require_once('enviarSoap.php');

// Load the XML to be signed
$doc = new DOMDocument();
$doc->load('RPSxml.xml');



$certificadoPem = dirname(__FILE__).'/certificado.pem';
$senha = "senha";

//Assinar rps
$xmlAssinado = assinarRps(dirname(__FILE__).'/RPSxml.xml');


//Enviar rps assinado
$resultado = transmitirRps($xmlAssinado, $certificadoPem, $senha);


//depois dependendo do resultado, vou criar uma função por exemplo ConsultaRps
//para consultar se realmente ocorreu tudo bem. 


