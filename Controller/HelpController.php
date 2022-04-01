<?php
class HelpController extends BaseController
{

    public function GetHelp() {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $helpModel = new HelpModel();

                
                $responseData = $helpModel->getHelp();
               
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

    public function getOneHelp($table) {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
 
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $HelpModel = new HelpModel();
                $responseData = $HelpModel->getOneGame($table);
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


}