<html>
<meta charset="utf-8">

<head>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="/js/script.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>



<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('connectdb.php'); #'inclusion' of php file to connect database for use

require ('../PHPMailer/src/Exception.php');
require ('../PHPMailer/src/PHPMailer.php');
$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$number = filter_input(INPUT_POST, 'number');
$start_date = filter_input(INPUT_POST,'startduration');
$end_date = filter_input(INPUT_POST,'endduration');
$booking_type=filter_input(INPUT_POST,'booking_type');
$adults=filter_input(INPUT_POST, 'adults');
$children=filter_input(INPUT_POST,'children');
$paymentname = filter_input(INPUT_POST,'paymentname');
$cardnum=filter_input(INPUT_POST,'payment1');
$cvnum=filter_input(INPUT_POST,'payment2');
$paymentexp=filter_input(INPUT_POST,'paymentexp');


function dateDiffInDays($date1, $date2)  
{ 
    // Calulating the difference in timestamps 
    $diff = strtotime($date2) - strtotime($date1); 
      
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds 
    return abs(round($diff / 86400)); 
}

$length = dateDiffInDays($start_date,$end_date);




if (!empty($name) || !empty($email) || !empty($number) || !empty($start_date) ||
!empty($end_date) || !empty($bookingtype) || !empty($adult) || !empty($children) || !empty($paymentname) ||
!empty($cardnum) || !empty($cvnum) || !empty($paymentexp)){

    function getToken($len=32){
        return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
    }
    $token = getToken(10);

    $sql = "SELECT nightly_rate FROM roomrates WHERE room = '$booking_type'";
    $result = $conn->query($sql);
    $rs = mysqli_fetch_array($result);

    $totalcharge = floatval($rs['nightly_rate']) * $length;

    
    $insert = "INSERT INTO bookings (full_name,email,telephone,start_date,end_date,num_nights,totalcharge,booking_type,num_adults,num_child,paymentname,cardnum,cvnum,paymentexp,token) values ('$name', '$email',
    '$number','$start_date','$end_date','$length','$length'*(select t1.nightly_rate from roomrates t1 where t1.room = '$booking_type'),'$booking_type','$adults','$children','$paymentname','$cardnum',
    '$cvnum', '$paymentexp','$token')";

    
    if($conn->query($insert)){
        // Load Composer's autoloader
        require '../vendor/autoload.php';

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";

// optional
// used only when SMTP requires authentication
        $mail->SMTPAuth = true;
        $mail->Username = 'itestmail50@gmail.com';
        $mail->Password = 'testingpurpose101';

        try{
            $mail->setFrom('itestmail50@gmail.com','Booking Confirmation');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject='Confirm Booking';
            $mail->Body='
            <table class="table">
            <thead>
            <h2>Your Booking Info</h2>
            </thead>
            <tbody>
            <tr>
            <th scope ="row">Name</th>
            <td>'.$name.'</td>
            </tr>
            <tr>
            <th scope ="row">From</th>
            <td>'.$start_date.'</td>
            </tr>
            <tr>
            <th scope ="row">To</th>
            <td>'.$end_date.'</td>
            </tr>
            <tr>
            <th scope ="row">Room Type</th>
            <td>'.$booking_type.'</td>
            </tr>
            <tr>
            <th scope ="row">Total Charge</th>
            <td>'.$totalcharge.'</td>
            </tr>
            </tbody></table>
            <strong>Confirm your booking:</strong><a href="http://localhost/SWENtestingproject-master/php/confirmation.php?email=' .$email .'&token=' .$token .'">Confirm your Booking here!</a><br>';
            $mail-> send();
            echo'<div class="alert alert-primary alert-dismissible" role="alert">
            Check your email to confirm booking!
            </div>';



        }catch (Exception $e){
            echo "essage couldnt be sent", $mail->ErrorInfo;
        }

        //header("location:availablerooms.php?booking=success");
        $conn->query("UPDATE available_rooms SET availability = availability - 1 WHERE room_type='$booking_type'");
      
    
}else {
    echo "All fields are required";
    die();
}





}


?>

</html>
