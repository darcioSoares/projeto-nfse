<?php

use Exception;



function transmitirRps($xmlAssinado,$certificadoPem,$senha){

        $wsdl = 'http '; //endereço de remessa
        $endpoint = "http "; // endereço homologação para envio
        $certificate = "$certificadoPem"; // certificado
        $password = $senha; // senha

        // altenticacao
        $options = Array(
            'location' => $endpoint,
            'keep_alive' => true,
            'trace' => true,
            'local_cert' => $certificate,
            'passphrase' => $password,
            'cache_wsdl' => WSDL_CACHE_NONE
        );


        try{
            $client = new SoapClient($wsdl, $options);
            $function = 'recepcionarLoteRpsLimitado'; // a funcão a ser ultilizada no web service
            $arguments = ['recepcionarLoteRpsLimitado' =>
            ['xml'=>$xmlAssinado]];             
            //no argumento estou dizendo que vou ultilizar essa funçao e já passar o xml assinado

            $options = [];
            $result = $client->__soapCall($function, $arguments, $options);
            //resultado (resposta) vem em xml falando se deu certo ou não

        }catch(Exception $e){

            echo $result . $e;
        }

    

}