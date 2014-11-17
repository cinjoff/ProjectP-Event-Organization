<!DOCTYPE HTML>
<html>
<body>

    <h1 style="width: 900px; margin-left: auto; margin-right: auto; display: block; text-align: center;">This spots are still available:</h1>
    <table style="width: 900px; margin-left: auto; margin-right: auto; display: block; border: solid; border-width: 1px;">
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
            $sql = "SELECT SpotNumber FROM spot WHERE IsReserved = 0;";
            $result = $conn->query($sql);
            $j = 0;
            echo "<tr>";
            foreach($result as $spot) {
                if (($j % 10) == 0)
                    echo "<tr>";
                echo "<td style='width: 90px; text-align: center; padding-top: 10px;'>$spot[SpotNumber]</td>";
                if (($j % 10) == 9)
                    echo "</tr>";
                $j++;
                
            }
        ?>
    </table>

</body>
</html> 