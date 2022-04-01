<?php
require __DIR__ . "/inc/bootstrap.php";
 
try {
    //Parse URL for to treat the link
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    $methode = $_SERVER['REQUEST_METHOD'];

    $isOne = "";
    $paramMethod = "";
    //Detect if the user want to login register or have a new password
    if (strtolower($uri[3]) == "register" || strtolower($uri[3]) == "login" || strtolower($uri[3]) == "forgot_password") {
        $objFeedController = new Authentification();
        $objFeedController->{strtolower($uri[3])}();
    } elseif (count($uri)-1 == 4 && $uri[count($uri)-1] != null) {
        $isOne = "One";
        $paramMethod =$uri[4];
    }

    //detect file and excecute the function
    $fileDetector = $uri[3]."Controller";
    $objFeedController = new $fileDetector();
    if ($isOne == "One" && ($uri[4] == "win" ||$uri[4] == "loose" ||$uri[4] == "equality")) {

        $objFeedController->{"updateScore"}($uri[4]);
    } else {
        $strMethodName = strtolower($methode).$isOne.ucfirst($uri[3]);
        $objFeedController->{$strMethodName}($paramMethod);
    }
} catch (Error $e) {

    if($methode == 'DELETE' && ($uri[3] != 'product' || $uri[3] != 'rate')) {
            echo "Sorry you can't delete a ".$uri[3]."\n\n\n $e";
    } else {
        echo "You probably put a wrong method or your link is incorrect\n\n\n$e";
    }
}


?>