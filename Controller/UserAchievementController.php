<?php
class UserAchievementController extends BaseController
{
    
    public function getUserAchievement()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userAchievementModel = new UserAchievementModel();
                $achievementModel = new AchievementModel();
                $intLimit = 10;
                if (isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }
                
                $arrUserAchievement = $userAchievementModel->getUserAchievements($intLimit);
                $arr = $arrUserAchievement;
                $finalArr = [];
                foreach ($arr[0] as $clé => $value){
                    if ($clé == "AchievementId"){
                        $query = $achievementModel->getOneAchievement($value); 
                        $finalArr["Achievement"] = $query;
                    }else{
                        $finalArr[$clé] = $value;
                    }
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
            // echo 'esponse data' . $responseData;
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

    public function getOneUserAchievement($id) {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userAchievementModel = new UserAchievementModel();
                $arruserAchievement = $userAchievementModel->getOneUserAchievement($id);
                $responseData = json_encode($arruserAchievement,JSON_INVALID_UTF8_SUBSTITUTE);
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

    public function postUserAchievement() {
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

                $userAchievementModel = new UserAchievementModel();
                $arrAchievement = $userAchievementModel->postUserAchievement(intval($eachKeyAndValue['UserId']),intval($eachKeyAndValue['AchievementId']),date("Y/m/d"));    
                
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