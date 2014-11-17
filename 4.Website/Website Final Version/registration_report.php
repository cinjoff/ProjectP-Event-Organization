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
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $age = $_POST["age"];
        $sex = $_POST["sex"];
        $emailAdr = $_POST["emailAdr"];
        $inputError = false;
    ?>
    
    <table class="formOutput">
        <tr>
            <td colspan="2" style="text-align: center;"><h3>You have input the following information: </h3></td>
        </tr>
        <tr>
            <td>First name: </td>
            <td>
                <?php
                    echo "$firstName";
                    if ($firstName == NULL) {
                        echo '<span class="inputError">Error: you have to enter your first name!</span>';
                        $inputError = true;
                    }   
                ?>
            </td>
        </tr>
        <tr>
            <td>Last name: </td>
            <td>
                <?php
                    echo "$lastName";
                    if ($lastName == NULL) {
                        echo '<span class="inputError">Error: you have to enter your last name!</span>';
                        $inputError = true;
                    }   
                ?>
            </td>
        </tr>
        <tr>
            <td>Age: </td>
            <td>
                <?php
                    echo "$age";
                    if ($age == NULL)
                        echo '<span class="inputError">Error: you have to enter your age!</span>';
                    elseif ($age < 16 || $age > 125) {
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="inputError">//age must be between 16 and 125!</span>';
                        $inputError = true;
                    }   
                ?>
            </td>
        </tr>
        <tr>
            <td>Sex: </td>
            <td>
                <?php
                    if ($sex == 'm')
                        echo 'Male';
                    elseif ($sex == 'f')
                        echo 'Female';
                ?>
            </td>
        </tr>
        <tr>
            <td>E-mail: </td>
            <td>
                <?php
                    if (strpos($emailAdr, "@") === false) {
                        echo '<span class="inputError">Error: e-mail address has to contain @ character!</span>';
                        $inputError = true;
                    }
                    else
                        echo $emailAdr;
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="resultRow">
                <?php 
                    if ($inputError === true)
                        echo '<span class="reservation"><a href="#">Go back to registration page and input valid data!</a></span></td>';
                    else {
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
                        $sql = "INSERT INTO client(FirstName, Age, LastName, gender, Email, Status) VALUES ('$firstName', '$age', '$lastName', '$sex', '$emailAdr', 'reserved');";
                        try {
                            $conn->query($sql);
                            $assignedId = $conn->lastInsertId();
                            $assignedIdLong = str_pad($assignedId, 6, '0', STR_PAD_LEFT);
                            $result = mail("$emailAdr", "Confirmation letter", "Congratulations! You are registered for LichtCamp event! Your Event Account number is $assignedIdLong. 
                                            You have to pay €30 when you enter this event , have fun !");
                            if ($result) {
                                echo 'You are registered now! ';
                                echo 'Your event account number is ';
                                echo $assignedIdLong;echo '.<br />';
                                echo "Letter with payment details has been sent to you.";
                            }
                            else {
                                echo 'Something wrong! We can\'t send a letter to you!';
                            }
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
        $conn=null;
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