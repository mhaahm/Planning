<?php


/*$request = curl_init('http://192.168.1.20/adminrd/reciveFile.php');

// send a file
curl_setopt($request, CURLOPT_POST, true);
curl_setopt(
    $request,
    CURLOPT_POSTFIELDS,
    array(
        'file' => '@'.realpath('D:/Temp/test.php') . ';filename=name.txt',
    ));

// output the response
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
echo curl_exec($request);

// close the session
curl_close($request);*/
copyFileWithCurl('D:/Temp/Test.php');
function copyFileWithCurl($file)
{
    print "Copiage du fichier $file \n";
    print dirname($file);
    if (function_exists('curl_file_create')) { // php 5.5+
        $cFile = curl_file_create($file);
    } else { //
        $cFile = '@' . realpath($file);
    }
    $post = array('file_path' => '/var/www/Temp/TestUploadCurl','file_contents'=> $cFile);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,'http://192.168.1.20/adminrd/reciveFile.php');
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $result = curl_exec ($ch);
    curl_close ($ch);

    var_dump($result);
}

