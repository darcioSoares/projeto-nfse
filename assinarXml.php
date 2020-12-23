<?php

use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

require_once('vendor/autoload.php');


    //posso passar o xml como paramentro
    // e já uso em doc->load()
function assinarRps(){


        // Load the XML to be signed
        $doc = new DOMDocument();
        $doc->load('RPSxml.xml'); // arquivo xml
        
        // Create a new Security object 
        $objDSig = new XMLSecurityDSig();
        // Use the c14n exclusive canonicalization
        $objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
        // Sign using SHA-256

        
        $objDSig->addReference(
            $doc, 
            XMLSecurityDSig::SHA256, //consultar qual o tipo da assinatura do meu certificado
            array('http://www.w3.org/2000/09/xmldsig#enveloped-signature')
        );
        
        // Create a new (private) Security key
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, array('type'=>'private'));
        /*
        If key has a passphrase, set it using
        $objKey->passphrase = '<passphrase>';
        */
        // Load the private key
        $objKey->loadKey('./path/to/privatekey.pem', TRUE);//cartificado em .pem
        
        // Sign the XML file
        $objDSig->sign($objKey); // esta assinando
        
        // Add the associated public key to the signature
        $objDSig->add509Cert(file_get_contents('./path/to/file/mycert.pem'));//passando dados extras
        
        // Append the signature to the XML
        $objDSig->appendSignature($doc->documentElement);//assinando o documento
        // Save the signed XML
        // $doc->save('./path/to/signed.xml'); //nesse caso estou pedindo para salvar e informando o caminho
        $xmlAssinado = $doc->saveXML(); // aqui esta me retornando o xml assinado
        

        return $xmlAssinado;

} // end function
