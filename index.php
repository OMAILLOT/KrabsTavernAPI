<?php
require __DIR__ . "/Inc/bootstrap.php";
 
try {
    //Parse URL for to treat the link
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );

    $methode = $_SERVER['REQUEST_METHOD'];

    $isOne = "";
    $paramMethod = "";
    //Detect if the user want to login register or have a new password
    if (strtolower($uri[2]) == "register" || strtolower($uri[2]) == "login" || strtolower($uri[2]) == "forgot_password") {
        $objFeedController = new Authentification();
        $objFeedController->{strtolower($uri[2])}();
    } elseif (count($uri)-1 == 3 && $uri[count($uri)-1] != null) {
        $isOne = "One";
        $paramMethod = $uri[3];
    }

    //detect file and excecute the function
    $fileDetector = $uri[2]."Controller";
    $objFeedController = new $fileDetector();
    if ($isOne == "One" && ($uri[3] == "win" ||$uri[3] == "loose" ||$uri[3] == "equality")) {

        $objFeedController->{"updateScore"}($uri[3]);
    } else {
        $strMethodName = strtolower($methode).$isOne.ucfirst($uri[2]);
        $objFeedController->{$strMethodName}($paramMethod);
    }
} catch (Error $e) {
    echo "You probably put a wrong method or your link is incorrect\n\n\n$e";
}


?>