<?
// TODO

/*

pear install stomp

Stuck here on:

configure: error: Cannot find OpenSSL's libraries
ERROR: `/tmp/pear/temp/stomp/configure --with-openssl-dir=/usr' failed


<?php

$queue  = '/topic/foo';

try {
    $stomp = new Stomp('tcp://localhost:61613');
    $stomp->subscribe($queue);
    while (true) {
       if ($stomp->hasFrame()) {
           $frame = $stomp->readFrame();
           if ($frame != NULL) {
               print "Received: " . $frame->body . " - time now is " . date("Y-m-d H:i:s"). "\n";
               $stomp->ack($frame);
           }
//       sleep(1);
       }
       else {
           print "No frames to read\n";
       }
    }
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

?>

*/
