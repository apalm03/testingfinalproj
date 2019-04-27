<html>
    <meta charset="utf-8">
    <head>
        <title>Hotel Testing</title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <script src="../js/script.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-3.4.0.min.js"></script>
        <script src="../js/jquery.tabledit.min.js" ></script>
        <script src="../js/jquery.tabledit.js" ></script>


    </head>
    
        <header id="banner">Hotel Comingle</header>
    <div>

        <div class= "col-sm-2" id="sidebar">

            <nav id="navigator">
                
                <a href="adminhome.php" style="color:white"><i class="glyphicon glyphicon-home"></i> <strong> Admin Home </strong></a><hr>
                 <p id="check-in" class="open-button" onclick="openForm()"><i class="glyphicon glyphicon-check"></i> <strong> Check-in Guest </strong></p><hr>
                 <a href="viewchecked.php" style="color:white"><i class="glyphicon glyphicon-eye-open"></i><strong>View Checked-in</strong></a><hr>
                <p id="check-out" class="open-button" onclick="opencheckoutForm()"> <i class="glyphicon glyphicon-unchecked"></i> <strong>Check-out Guest </strong></p><hr>
               <a href="logout.php" style="color:white"><i class="glyphicon glyphicon-log-out"></i>  <strong> Logout </strong></a>
                
            </nav>
            
    </div>
    
    <?php

  session_start();




  if (isset($_SESSION["id"])) { //if you have more session-vars that are needed for login, also check if they are set and refresh them as well

    $_SESSION["id"] = $_SESSION["id"];

  }

    if ( isset($_GET['success']) && $_GET['success'] == 1 )
    {
        // treat the succes case ex:
        echo"<script language='Javascript'>alert('Successfully checked in');</script>";
    }
?>

    <div class="col-xs-10">
                 
    <h1>Guest List</h1>
    <div>
        <div class="col col-4" style="margin: auto; ">
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name" class="form-control">
        </div>
      <button type="button" id="delete" class="btn btn-danger" style="
    float: right;margin-bottom: 10px;"><div class="glyphicon glyphicon-trash"></div> Delete Selected</button>
        <div class="table-responsive">
    <table class="table table-hover table-bordered" id="guest">

      <tr>
        <th><input type="checkbox" id="checkAll"/></th>  
        <th>ID#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Telephone</th>
        <th>From</th>
        <th>To</th>
        <th>Room Type</th>
        <th>Number Of Adults</th>
        <th>Number of Children</th>
          <th></th>
      </tr>

      <?php
     require_once('connectdb.php');
      $sql = "SELECT customer_id,full_name,email,telephone,start_date,end_date,booking_type,num_adults,num_child from bookings";
      $result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result ->fetch_assoc()) {
        ?>
        <tbody id="myTable" >
        <tr>
        <td><input class="checkbox" type="checkbox" name="id[]" id="<?php echo $row['customer_id'] ?>"/>
        <td><?php echo $row['customer_id'] ?></td>
        <td class="col-xs-1.5"> <?php echo $row['full_name'] ?> </td>
        <td><a href="#"> <?php echo $row['email'] ?></a> </td>
        <td> <?php echo $row['telephone'] ?> </td>
        <td> <?php echo $row['start_date'] ?> </td>
        <td> <?php echo $row['end_date'] ?> </td>
        <td> <?php echo $row['booking_type'] ?> </td>
        <td class="col-xs-1"> <?php echo $row['num_adults'] ?> </td>
        <td class="col-xs-1.5"> <?php echo $row['num_child'] ?> </td>
            <td ><a href="edit.php?id=<?php echo $row['customer_id']; ?>" class="btn btn-default"><div class="glyphicon glyphicon-pencil"></div> Edit</a></td>
        </tr>
        <?php      }
        }else{
        echo "0 results";
        }
        $conn-> close();
        ?>
        </tbody>

    </table>
        </div>
  
    </div>
    </div>
	
<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>


        <script>
$(document).ready(function(){
    $('#checkAll').click(function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked=true;
            });
            
        }else{
            $('.checkbox').each(function(){
                this.checked=false;
            })
        }
    });
    $('#delete').click(function(){
    var dataArr = new Array();
    if($('input:checkbox:checked').length > 0){
      $('input:checkbox:checked').each(function(){
        dataArr.push($(this).attr('id'));
        $(this).closest('tr').remove();
      }); 
      sendResponse(dataArr)
    }else{
        alert('no records selected ')
    }
});
function sendResponse(dataArr){
    $.ajax({
        type:'post',
        url:'function.php',
        data : {'data' :dataArr},
        success:function(response){
            alert(response);
        },
        error : function(errResponse){
            alert(errResponse);
        }
    })
}


});

$(document).ready(function(){
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

</script>


<div class="form-popup col-sm-4" id="myForm">
  <form action="checkinprocess.php" class="form-container" method="post">
    <h1>Check-in</h1>
    <div class="form-group">
    <label for="id"><b>ID#</b></label>
    <input class="form-control" type="number" placeholder="Enter Guest's id number" name="id" required>
    </div>
    <div class="form-group">
    <label for="name"><b>Fullname</b></label>
    <input type="text" class="form-control" placeholder="Enter Guest's name" name="name" required>
    </div>
    <div class="form-group">
     <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
  <span><input type="submit" class="btn btn-danger" onclick="closeForm()" value="Close"></span>
</div>

<div class="form-popup col-sm-4" id="myoutForm">
  <form action="checkoutprocess.php" class="form-container" method="post">
    <h1>Check-out</h1>
    <div class="form-group">
    <label for="id"><b>ID#</b></label>
    <input class="form-control" type="number" placeholder="Enter Guest's id number" name="id" required>
    </div>
    <div class="form-group">
    <label for="name"><b>Fullname</b></label>
    <input type="text" class="form-control" placeholder="Enter Guest's name" name="name" required>
    </div>
    <div class="form-group">
     <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
  <span><input type="submit" class="btn btn-danger" onclick="closecheckoutForm()" value="Close"></span>
</div>



    
    
    </div>

    </body>
</html>

