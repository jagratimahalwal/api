<?php

/***********************************
 * PHP API for search the restaurnt on the basis of name.
 * Used Method ilike to match in both the cases. We can use the 'in' operator if selecting the name from pre-defined 
 * drop down list.
 * 
 * REQUEST_METHOD for this API is POST
 **********************************/
    include_once '../log/generateLog.php';
    include_once './checkAppVersion.php';
    include_once '../actions/action.php';                                                                                                                                           

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
      http_response_code(405); //Setting response code for the response
      outputLog("Response Code : 405");
      echo json_encode(
        array("message" => "Method Not Allowed","status"=>405)
      );  
      exit;
    }

    //IF method is POST

    $apiBody = file_get_contents('php://input'); // Reading raw-post data
    $parsedBody = json_decode($apiBody,true); //decoding json to array
    $searchRestaurant = $parsedBody['name'];
    

    //If Sorting on base of some criteria
    if(!$searchRestaurant){
        http_response_code(404); 
        echo json_encode(
          array("message" => "Please provide name to perform search","status"=>404)
        );
        exit;
    }else{

        outputLog("Searched Restaurnt Name :". $searchRestaurant);  // Logging the exact word being searched for.
  
        if(is_old_android()){
          //If true then Restaurant name will be searched instead of restaurant.
          $searchQuery = 'SELECT "id","RestaurantName","branch", "latitude","longitude","url","open", "bestMatch","newestScore","ratingAverage","popularity","averageProductPrice","deliveryCosts","minimumOrderAmount" FROM restaurant_schema.restaurants_details';
          $searchQuery .= " WHERE 'RestaurantName' ilike  ";
        }else{
          $searchQuery = 'SELECT "id","name","branch", "latitude","longitude","url","open", "bestMatch","newestScore","ratingAverage","popularity","averageProductPrice","deliveryCosts","minimumOrderAmount" FROM restaurant_schema.restaurants_details';
          $searchQuery .= " WHERE name ilike ";
        }
          
        outputLog("Query Executed :". $searchQuery); // For debugging purpose what query is being executed in DB

        $response = searchList($searchQuery,$searchRestaurant); //Function call to perform db operation
        echo $response;
      }
  

    
    
?>