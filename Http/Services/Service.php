<?php
namespace App\Http\Services;
require_once "config/Apiconnection.php";
use App\Model\MySQLiContainer;

class Services 
{
    /**
     * Get details from api
     * @return object
     */
    public function index()
    {
          $insertArray = array();
          $insertProperty = array();
          $apiResult = $this->apiExecution();
         //  echo "<pre>"; print_r($apiResult["result"]->data); exit;
          if($apiResult["status"]) {
              $currentPage = $apiResult["result"]->current_page;
              $lastpage = $apiResult["result"]->last_page;
              $apidData = $apiResult["result"]->data;
              $this->dataRetrival($apidData,$lastpage,$currentPage);
          }
    }

   /**
     * Get details from api
     * @param $index string
     * @return array
     */

    private function apiExecution($index = "") 
    {
        $ch = curl_init(API_URL.$index);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $abc);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $res = json_decode($result);
         if(!empty($res)) {
             return[
                 "status" => "true",
                 "result"=>$res
             ];
         } else {
            return[
                "status" => "false",
            ];
         }
    }

   /**
     * insert details from api
     * @param $lastpage string
     * @param $currentPage string
     * @param $apidData array
     * @return array
     */

    private function dataRetrival($apidData = array(),$lastpage = "",$currentPage = "") {

             while ($currentPage<=$lastpage){

                foreach($apidData  as $result) {
                    foreach($result as $key=>$value){
                        if($key=='property_type') {
                         $insertArray["property_type_id"] = $value->id;
                         foreach ($value as $seckey=>$secval) {
                             if($secval){
                             $insertProperty[$seckey] = $secval;
                             }
                         }
                        } else {
                         $insertArray[$key] = $value;
                        }
                    }
                   // echo $result->uuid; 
                   $detailsTable = details;
                   $propertyTable = property;
                    $mysql = new MySQLiContainer();
                    $mysql->InsertData($detailsTable,$insertArray);
                    $mysql->InsertData($propertyTable,$insertProperty); 
                }
                $currentPage++;
                $apidData = $this->apiExecution($currentPage);
             } 

    }


}
