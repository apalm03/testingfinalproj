<?php
require_once("connectdb.php");
$userObj =mysqli_query($conn,'SELECT * FROM `bookings`');

if(isset($_POST['data'])){
    $dataArr=$_POST['data'];



    foreach($dataArr as $id){
        mysqli_query($conn, "UPDATE available_rooms SET availability = availability + 1  WHERE  room_type = (SELECT booking_type FROM bookings WHERE customer_id='$id')");
        mysqli_query($conn,"DELETE FROM bookings  where customer_id='$id'");
        
    }
    echo 'record deleted successfully';
}

?>