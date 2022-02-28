<?php
include "config.php";

$data = json_decode(file_get_contents("php://input"));

$request = $data->request;

// Fetch All records
if($request == 1){
  $userData = mysqli_query($con,"select * from bday order by month asc, day asc");

  $response = array();
  while($row = mysqli_fetch_assoc($userData)){
    $response[] = $row;
  }

  echo json_encode($response);
  exit;
}

// Add record
if($request == 2){
  $id = $data->id;
  $name = $data->name;
  $month = $data->month;
  $day = $data->day;
  $year = $data->year;

  $userData = mysqli_query($con,"SELECT * FROM bday WHERE id='".$id."'");
  if(mysqli_num_rows($userData) == 0){
    mysqli_query($con,"INSERT INTO bday(id,name,month,day,year) VALUES('".$id."','".$name."','".$month."','".$day."','".$year."')");
    echo "Insert successfully";
  }else{
    echo "id already exists.";
  }

  exit;
}

// Update record
if($request == 3){
  $id = $data->id;
  $name = $data->name;
  $month = $data->month;
  $day = $data->day;
  $year = $data->year;

  mysqli_query($con,"UPDATE bday SET name='".$name."',month='".$month."',day='".$day."',year='".$year."' WHERE id=".$id);
 
  echo "Update successfully";
  exit;
}

// Delete record
if($request == 4){
  $id = $data->id;
  $ishidden = 1;

  // mysqli_query($con,"DELETE FROM bday WHERE id=".$id);
  mysqli_query($con,"UPDATE bday SET ishidden='".$ishidden."' WHERE id=".$id);

  echo "Delete successfully";
  exit;
}

?>