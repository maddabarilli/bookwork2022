<?php
     require_once 'vendor/autoload.php';

     $client = new Google\Client();
     $client->setApplicationName("Client_Library_Examples");
     $client->setDeveloperKey(""); //inserire la key tra le virgolette
     $client->setAuthConfig('credentialsAuth.json');
     
     $service = new Google\Service\Books($client);
     //print_r($service);
?>