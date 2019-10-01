<?php

/********************************************************************
 * Sort API to sort the restaurnt list basis of sort criteria bestMatch, popularity, newestScore
 * ratingAverage, product price, delivery cost minimum order. If no criteria is provided then it will sort 
 * on the basis of open. Assuming 
 * 1-open 
 * 2-order early
 * 0-closed.
 *************************************************************/

    include_once '../log/generateLog.php';
    include_once './checkAppVersion.php';   
    include_once '../actions/action.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");


    //Query to fetch data from database;
    if(is_old_android()){
        $sortQuery = 'SELECT "id","RestaurantName","branch", "latitude","longitude","url","open", "bestMatch","newestScore","ratingAverage","popularity","averageProductPrice","deliveryCosts","minimumOrderAmount" FROM restaurant_schema.restaurants_details';
    }else{
      $sortQuery = 'SELECT "id","name","branch", "latitude","longitude","url","open", "bestMatch","newestScore","ratingAverage","popularity","averageProductPrice","deliveryCosts","minimumOrderAmount" FROM restaurant_schema.restaurants_details';
    }
    
    //If Sorting on base of some criteria
    if($_GET['sortBy']){
        outputLog("Sorted Restaurnt  :". $_GET['sortBy']);
        switch($_GET['sortBy']){

          //Appending the order by in the select query 
          //Ordering the list on the bases off sort value.

          case "bestMatch" : $sortQuery .=  ' ORDER BY "bestMatch" ASC ';
            break;
          case "popularity" : $sortQuery .= ' ORDER BY "popularity" ASC';
            break;
          case "newestScore" : $sortQuery .= ' ORDER BY "newestScore" ASC';
            break;
          case "ratingAverage" : $sortQuery .= ' ORDER BY "ratingAverage" DESC';
            break;
          case "averageProductPrice" : $sortQuery .= ' ORDER BY "averageProductPrice" ASC';
            break;
          case "deliveryCosts" : $sortQuery .= ' ORDER BY "deliveryCosts" ASC';
            break;
          case "minimumOrderAmount" : $sortQuery .= ' ORDER BY "minimumOrderAmount" ASC';
            break;
          default : $sortQuery .= ' ORDER BY case when open = 0 then 0 else 1 end, open ASC';
            break;
        }

    }

    else {
        //In case no sorting option is provided then sort basis of open
        $sortQuery .= ' ORDER BY case when open = 0 then 1 else 0 end, open ASC';

    }
    outputLog("Query Executed :". $sortQuery);  // For debugging purpose what query is being executed in DB

    $response =  readList($sortQuery); //Function call to perform db operation
    echo $response;

?>