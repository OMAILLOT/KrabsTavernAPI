<?php
class ScoreController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
     
    public function getScore()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $scoreModel = new ScoreModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                
                $arrScores = $scoreModel->getScores($intLimit);
                $responseData = json_encode($arrScores,JSON_INVALID_UTF8_SUBSTITUTE);
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
            // echo $responseData;
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

    public function getOneGame($id) {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $scoreModel = new ScoreModel();
                $arrGames = $scoreModel->getOneScore($id);
                $responseData = json_encode($arrGames,JSON_INVALID_UTF8_SUBSTITUTE);
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
            // echo $responseData;
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

    public function postScore() {
            
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        
        if ($requestMethod == 'POST') {
            
            try {
                $postBody = file_get_contents("php://input");
                $explodePostBody = explode( '&', $postBody);
                $eachKeyAndValue = array();
                foreach($explodePostBody as $value) {
                    $explodeKeyAndValue = explode( '=', $value); 
                    $eachKeyAndValue[$explodeKeyAndValue[0]] = $explodeKeyAndValue[1];
                }

                $scoreModel = new ScoreModel();
                $arrScores = $scoreModel->postScore($eachKeyAndValue['GameId'], $eachKeyAndValue['UserId']);    
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage()."Can't get the commands";
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $arrScores;
            $successfulMessage = "Score successfully added!";
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

    public function updateScore($whatScore) {
        $whatScore = "update".$whatScore;
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        
        if ($requestMethod == 'POST') {
            
            try {
                $postBody = file_get_contents("php://input");
                $explodePostBody = explode( '&', $postBody);
                $eachKeyAndValue = array();
                foreach($explodePostBody as $value) {
                    $explodeKeyAndValue = explode( '=', $value); 
                    $eachKeyAndValue[$explodeKeyAndValue[0]] = $explodeKeyAndValue[1];
                }

                $scoreModel = new ScoreModel();

                $arrScores = $scoreModel->$whatScore($eachKeyAndValue['GameId'], $eachKeyAndValue['UserId']);    
                
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage()."Can't get the commands";
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
 
        // send output
        if (!$strErrorDesc) {
            $arrScores;
            $successfulMessage = "Score successfully update!";
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

}