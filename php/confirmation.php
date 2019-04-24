<?php
require('newbooking.php');
require('connectdb.php');
if($_GET){
    if(isset($_GET['email'])){
        $email=$_GET['email'];

    }
    if(isset($_GET['token'])){
        $token = $_GET['token'];

    }
    if(!empty($email) && !empty($token)){
        $select = "SELECT customer_id from bookings WHERE email='$email' and token ='$token'";
        $result = $conn->query($select);

        if ($result->num_rows > 0) {

                $conn->query("UPDATE bookings SET confirmation = 1, token = '' where email ='$email'");

            header("location:availablerooms.php?booking=success");
            $conn->query("UPDATE available_rooms SET availability = availability - 1 WHERE room_type='$booking_type'");

            echo '<script> alert("Booking Sucessfully confirmed") </script>';


        }else{
            echo "shot";
        }

    }
}

?>