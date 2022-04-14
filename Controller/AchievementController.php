<?php
class AchievementController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
     
    public function getAchievement()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $achievementModel = new AchievementModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                
                $arrAchievement = $achievementModel->getAchievements($intLimit);
                $arr = $arrAchievement;
                $finalArr = [];
                $arrAchievements = [];
                foreach($arr as $achievement){
                    foreach ($achievement as $clé => $value){
                        if ($clé == "GameId"){
                            $query = $achievementModel->getAGameTitle($value);
                            $arrAchievements["Game"] = $query[0]['Title'];
                        }else{
                            $arrAchievements[$clé] = $value;
                        }
                    }
                    array_push($finalArr, $arrAchievements);
                }
                $responseData = json_encode($finalArr,JSON_INVALID_UTF8_SUBSTITUTE);
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

    public function getOneAchievement($id) {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $achievementModel = new AchievementModel();
                $arrUsers = $achievementModel->getOneAchievement($id);
                $arr = $arrUsers;
                $finalArr = [];
                $arrAchievements = [];
                foreach($arr as $achievement){
                    foreach ($achievement as $clé => $value){
                        if ($clé == "GameId"){
                            $query = $achievementModel->getAGameTitle($value);
                            $arrAchievements["Game"] = $query[0]['Title'];
                        }else{
                            $arrAchievements[$clé] = $value;
                        }
                    }
                    array_push($finalArr, $arrAchievements);
                }
                $responseData = json_encode($finalArr,JSON_INVALID_UTF8_SUBSTITUTE);
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

    public function postAchievement() {
            
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

                $AchievementModel = new AchievementModel();
                $title = str_replace(['%20']," ",$eachKeyAndValue['Title']);
                $title = str_replace(['%2C'],",",$title);

                $overview = str_replace(['%20']," ",$eachKeyAndValue['Overview']);
                $overview = str_replace(['%2C'],",",$overview);
                $overview = str_replace(['%21'],"!",$overview);
                $arrAchievement = $AchievementModel->postAchievement(intval($eachKeyAndValue['GameId']),
                                                                     $title,
                                                                     $overview);    
                
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
            $arrAchievement;
            $successfulMessage = "Achievement successfully added!";
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