<?php
    class Authentification extends BaseController {

        public function register() {
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
     
            if (strtoupper($requestMethod) == 'POST') {
                try {
                    //Treat the body that send
                    $postBody = file_get_contents("php://input");
                    $explodePostBody = explode( '&', $postBody);
                    $eachKeyAndValue = array();
                    foreach($explodePostBody as $value) {
                        $explodeKeyAndValue = explode( '=', $value); 
                        $eachKeyAndValue[$explodeKeyAndValue[0]] = $explodeKeyAndValue[1];
                    }
                    
                    $authentificationModel = new AuthentificationModel();
                    $gameModel = new GameModel();
                    //Send all information to the model
                    $register = $authentificationModel->register(
                        $eachKeyAndValue['Name'],
                        str_replace(['%40'],"@",$eachKeyAndValue['EmailAddress']),
                        password_hash($eachKeyAndValue['Password'], PASSWORD_DEFAULT),
                        $gameModel->GetMaxId(),
                    );


                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
     
            // send output
            if (!$strErrorDesc) {
                if($register == "your identifier already exist") {
                    $successfulMessage = "your identifier already exist";
                } else {
                    $successfulMessage = "You register successfuly : \nyour information :\nId : ".$authentificationModel->getMaxId()."\nPseudo : ".$eachKeyAndValue['Name']."\nMail : ".str_replace(['%40'],"@",$eachKeyAndValue['EmailAddress']);
                }
                $this->sendOutput(
                    $successfulMessage,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function login() {
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
     
            if (strtoupper($requestMethod) == 'POST') {
                try {
                    //Treat the body that send
                    $postBody = file_get_contents("php://input");
                    $explodePostBody = explode( '&', $postBody);
                    $eachKeyAndValue = array();
                    foreach($explodePostBody as $value) {
                        $explodeKeyAndValue = explode( '=', $value); 
                        $eachKeyAndValue[$explodeKeyAndValue[0]] = $explodeKeyAndValue[1];
                    }
                    
                    $authentificationModel = new AuthentificationModel();
                    //Send all information to the model
                    $login = $authentificationModel->login(str_replace(['%40'],"@",$eachKeyAndValue['Identifier']),$eachKeyAndValue['Password']);
                    $responseData = json_encode($login,JSON_INVALID_UTF8_SUBSTITUTE);
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
     
            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function forgot_password() {
            $strErrorDesc = '';
            $requestMethod = $_SERVER["REQUEST_METHOD"];
     
            if (strtoupper($requestMethod) == 'POST') {
                try {
                    //Treat the body that send
                    $postBody = file_get_contents("php://input");
                    $explodePostBody = explode( '&', $postBody);
                    $eachKeyAndValue = array();
                    foreach($explodePostBody as $value) {
                        $explodeKeyAndValue = explode( '=', $value); 
                        $eachKeyAndValue[$explodeKeyAndValue[0]] = $explodeKeyAndValue[1];
                    }
                    
                    $authentificationModel = new AuthentificationModel();
                    //Send all information to the model
                    $login = $authentificationModel->forgot_password($eachKeyAndValue['UserId'],str_replace(['%40'],"@",$eachKeyAndValue['EmailAddress']));
                    $responseData = json_encode($login,JSON_INVALID_UTF8_SUBSTITUTE);
                } catch (Error $e) {
                    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
                }
            } else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
     
            // send output
            if (!$strErrorDesc) {
                $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            } else {
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }
        
    }
?>