<?php
include('connectdb.php');
$id=$_GET['id'];
$query=mysqli_query($conn,"select full_name, email, telephone, start_date, end_date, booking_type, num_adults, num_child from `bookings` where customer_id='$id'");
$row=mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Info</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<h2>Edit</h2>
<form method="POST" action="update.php?id=<?php echo $id; ?>">
    <label >Full name:</label> <input type="text"  value="<?php echo $row['full_name']; ?>" name="name" required >
    <label >Email:</label> <input type="email" value="<?php echo $row['email']; ?>" name="email" required>
    <label >Telephone:</label> <input type="telephone" value="<?php echo $row['telephone']; ?>" name="number"required>
    <label >Start:</label> <input type="date" value="<?php echo $row['start_date']; ?>" name="startduration"required>
    <label>End:</label> <input type="date" value="<?php echo $row['end_date']; ?>" name="endduration" required><br><br>
    <label>Booking Type:</label> <select name='booking_type' id='booking_type'  required>
        <option value="" disabled selected><?php echo $row['booking_type']?></option>
        <option>Penthouse</option>
        <option>Family Suite</option>
        <option>Double Room</option>
        <option>Single Room</option>
    </select>
    <label>No.Adults</label> <input type="number" class="col-sm-1" value="<?php echo $row['num_adults']; ?>" name="adults"required>
    <label>No.Children</label> <input type="number" class="col-sm-1" value="<?php echo $row['num_child']; ?>" name="children" required>
   <br>
    <input  type="submit" name="submit" class="btn btn-success" value="Save"/>
    <button onclick="history.go(-1);">Back </button>

</form>
</body>
</html>