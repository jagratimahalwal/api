<?php
include_once '../config/conf.php';
include_once '../log/generateLog.php';
include_once '../v1.0/checkAppVersion.php';

function readList($query){
  $database = new Database();   // instantiate database object
  $db = $database->getConnection();

  $result = pg_query($db , $query);
  if (!$result) {
      outputLog("Error occurred while querying the DB" . pg_last_error()); //Logging error into the log files
      http_response_code(500);
      return json_encode(
          array("message" => "Error occurred while querying the DB","status"=>500)
      );
      exit;
  }
  $dataList = pg_fetch_all($result);
  if(empty($dataList)){
     
    http_response_code(404);  // set response code - 404 Not found
    outputLog("Response Code : 404");
    // Set message to no restaurant found
    return json_encode(
        array("message" => "No restaurant found.","status"=>404)
    );
  }else{

    http_response_code(200); // set response code - 200 OK
    outputLog("Response Code : 200");
    $response['message'] = 'OK';
    $response['status'] = 200;
    $response['records'] = $dataList;
    return json_encode($response); // show restaurant data in json format
  }
}

function searchList($query, $restaurant){
        $database = new Database();   // instantiate database object
        $db = $database->getConnection();  
        
        pg_prepare($db, "getRest", $query.'$1');
        $result = pg_execute($db, "getRest", array($restaurant));
        
        //If there is error and the query is not executed.
        if (!$result) {
          outputLog("Error occurred while querying the DB" . pg_last_error()); //Logging error into the log files
          http_response_code(500);
          return json_encode(
              array("message" => "Error occurred while querying the DB","status"=>500)
          );
          exit;
        }
        $restaurantDetails = pg_fetch_assoc($result);

        if (!$restaurantDetails) {
          http_response_code(404);  // set response code - 404 Not found
          outputLog("Response Code : 404");
          // Set message to no restaurant found
          return json_encode(
              array("message" => "No restaurant found.","status"=>404)
          );
        }else{
          http_response_code(200); // set response code - 200 OK
          outputLog("Response Code : 200");
          $response['message'] = 'OK';
          $response['status'] = 200;
          $response['records'][0] = $restaurantDetails;
          return json_encode($response); // show restaurant data in json format
        }
}
?>