<?php

include('connectdb.php');
$id = $_GET['id'];

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$number = filter_input(INPUT_POST, 'number');
$start_date = filter_input(INPUT_POST,'startduration');
$end_date = filter_input(INPUT_POST,'endduration');
$booking_type=filter_input(INPUT_POST,'booking_type');
$adults=filter_input(INPUT_POST, 'adults');
$children=filter_input(INPUT_POST,'children');

mysqli_query($conn, "update `bookings` set full_name='$name', email='$email', telephone='$number',start_date='$start_date', end_date='$end_date', booking_type='$booking_type',num_adults='$adults',num_child='$children'  where customer_id='$id'");
header('location:adminhome.php');
