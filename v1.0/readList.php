<?php
/******************************************
 * ReadList API to fetch the whole list of restaurnt in the database.
 * And return the response in JSON format.
 *************************************/
  include_once '../log/generateLog.php';
  include_once './checkAppVersion.php';   
  include_once '../actions/action.php';

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  
  
  
 //Query to fetch data from database 
  if(is_old_android()){
        $listQuery = 'SELECT "id","RestaurantName","branch", "latitude","longitude","url","open", "bestMatch","newestScore","ratingAverage","popularity","averageProductPrice","deliveryCosts","minimumOrderAmount" FROM restaurant_schema.restaurants_details';
  }else{
        $listQuery = 'SELECT "id","name","branch", "latitude","longitude","url","open", "bestMatch","newestScore","ratingAverage","popularity","averageProductPrice","deliveryCosts","minimumOrderAmount" FROM restaurant_schema.restaurants_details';
  }
  
  outputLog("Query Executed :". $listQuery); //For debugging
  $response =  readList($listQuery); //Function call to perform db operation
  echo $response;

  
?> 