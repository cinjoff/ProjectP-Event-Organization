<!DOCTYPE HTML>
<html>
<body>
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
        $sql = "INSERT INTO spot VALUES();";
            for($i=1; $i<222; $i++)
                $conn->query($sql);
        
?>

</body>
</html> 