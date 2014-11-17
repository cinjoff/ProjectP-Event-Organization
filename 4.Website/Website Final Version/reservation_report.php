<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Camp</title>
<link href="Menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-1.9.1.js"></script>
<script type="text/javascript" src="js.js"></script>
</head>
<body>
<div id="menu">
    <div id="test">
        <img src="1.jpg" height="200" width=100% />
    </div>
	
    <div id="submenu">
        <div id="sub">
            <ul>
            <li class="home"><a href="index.html">Home</a></li>
                    <li class="photo"><a href="#">Photo</a></li>
                    <li class="reservation"><a href="#">Registration</a></li>
                    <li class="about"><a href="#">About</a></li>
                    <li class="contact"><a href="#">Contact</a></li>
            </ul>
        </div><!--close for sub-->
    </div>
</div>
    
    
    
    
<div id="content">
    <?php
        //Assign values of the form to the variables
        $spotNumber = $_POST["spotNumber"];
        $eventAccount = $_POST["eventAccount"];
        $numberOfGuests = $_POST["numberOfGuests"];
        $lastNames = $_POST["lastNames"];
        $inputError = false;
    ?>
    <?php
        $username = "dbi251195";
        $password = "GME7PlrdGQ";
        try 
        {
            $conn = new PDO('mysql:host=localhost;dbname=dbi251195', $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) 
        {
            echo "Connection failded: " . $e->getMessage();
        }

        $eventAccountExist = true;
        $spotIsFree = true;
        $hasNoSpot = true;
        //Check if client with such EventAccount exists
        $sql1 = "SELECT * FROM client WHERE EventAccount='$eventAccount'";
        $result1 = $conn->query($sql1);
        $howMuchRows = $result1->rowCount();
        if ($howMuchRows == 0)
            $eventAccountExist = false;
        //Check if spot is reserved
        $sql2 = "SELECT * FROM spot WHERE SpotNumber='$spotNumber'";
        $result2 = $conn->query($sql2);
        $isSpotFree = $result2->fetch();
        if ($isSpotFree['IsReserved'] == 1)
            $spotIsFree = false;
        //Check if this client has already booked a spot
        $sql5 = "SELECT * FROM reservation WHERE EventAccount='$eventAccount'";
        $result3 = $conn->query($sql5);
        $howMuchRows3 = $result3->rowCount();
        if ($howMuchRows3 == 1)
            $hasNoSpot = false;
    ?>
    
    <table class="formOutput">
        <tr>
            <td colspan="2" style="text-align: center;"><h3>You have input the following information: </h3></td>
        </tr>
        <tr>
            <td>Spot number: </td>
            <td>
                <?php
                    echo "$spotNumber";
                    if ($spotNumber == NULL) {
                        echo '<span class="inputError">Error: you have to enter your first name!</span>';
                        $inputError = true;
                    }
                    if ($spotIsFree == false) {
                        echo '<span class="inputError"> //this spot is already reserved!</span>';
                        $inputError = true;
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Event Account: </td>
            <td>
                <?php
                    echo "$eventAccount";
                    if ($eventAccount == NULL) {
                        echo '<span class="inputError">Error: you have to enter your account number!</span>';
                        $inputError = true;
                    }
                    elseif ($eventAccountExist == false) {
                        echo '<span class="inputError">Error: there is no such event account!</span>';
                        $inputError = true;
                    }
                    elseif ($hasNoSpot == false) {
                        echo '<span class="inputError"> //this user has already booked a spot!</span>';
                        $inputError = true;
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Number of guests: </td>
            <td>
                <?php
                    echo "$numberOfGuests";
                ?>
            </td>
        </tr>
        <tr>
            <td>Last names of guests: </td>
            <td>
                <?php
                    echo "$lastNames";
                    if ($lastNames == NULL) {
                        echo '<span class="inputError">Error: you have to enter your last name!</span>';
                        $inputError = true;
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="resultRow">
                <?php 
                    if ($inputError === true)
                        echo '<span class="reservation"><a href="#">Go back to reservation page and input valid data!</a></span></td>';
                    else {
                        $sql3 = "INSERT INTO reservation(EventAccount, SpotNumber, NumberOfGuests, LastNames) VALUES ('$eventAccount', '$spotNumber', '$numberOfGuests', '$lastNames');";
                        $sql4 = "UPDATE spot SET IsReserved = 1 WHERE SpotNumber = '$spotNumber'";
                        try {
                        $conn->query($sql3);
                        $assignedId = $conn->lastInsertId();
                        $conn->query($sql4);
                        
                        
                        $paymantForSpot = 30 + 20*$numberOfGuests;
						$sql5 = "UPDATE client SET AccountBalance = -($paymantForSpot)  WHERE EventAccount = $eventAccount";
						$conn->query($sql5);
                        echo "You have register a spot number ";
                        echo $spotNumber;echo ".<br />";
                        echo 'Your reservation number is ';
                        echo str_pad($assignedId, 6, '0', STR_PAD_LEFT); echo '.<br />';
                        echo "Now trasfer $paymantForSpot euros to our account.";
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                            echo "Something wrong with our sever. Try to register later.";
                        }
                    }
                ?>
            </td>
        </tr>
    </table>
    
    <?php
        for($i = 1; $i < 11; $i++)
            echo '<br />';
    ?>
    
    
    
    
    
</div><!--close for content-->




<br />
<div id="footer">
<div id="foot">
<img src="LightCamp_Logo_fixedA - Copy.png" height="70" />
	<div id="copy">
		&copy; 2013 All rights reserved.
	</div>
		<hr color="#FFFFFF" size="0.3" />
		<div id="links">
		<p><a href="#"> Frequently Asked Questions</a></p><br />
		<p><a href="#"> About Us</a></p><br />
		<p><a href="#"> Contact Us</a></p><br />
		</div>
        <div id="icon">
        </div>
</div>
</div>
</body>
</html>