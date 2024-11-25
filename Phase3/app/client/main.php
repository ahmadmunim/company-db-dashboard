<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link rel="stylesheet" href="../../styles.css">
</head>
<body>
    <h1>Hello Client!</h1>

    <!--Client Buttons--> 
    <div class ="container">
        <form class="menu-btn" method ="POST" action="../../controller.php">
            <!--Project Button-->
            <button type="submit" name="projectBtn" >Projects</button>
            <!--View Employee information button-->
            <button type="submit" name = "viewEmpBtn">View Employee Information</button>
            <!--View Manager information button -->
            <button type="submit" name="viewManagerBtn">View Manager Information</button>
        </form>

        <div class="right-content">

        </div>
        
    </div>
</body>
</html>