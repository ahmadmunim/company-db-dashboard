<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
</head>
<body>
    <h1 style ="text-align:center">Client</h1>

    <!--Client Buttons--> 
    <div class ="container">
        <form method ="POST" action="../../controller.php">
            <!--Project Button-->
            <button type="submit" name="projectBtn" >Projects</button>
            <p></p>
            <!--View Employee information button-->
            <button type="submit" name = "viewEmpBtn">View Employee Information</button>
            <p></p>
            <!--View Manager information button -->
            <button type="submit" name="viewManagerBtn">View Manager Information</button>
            <p></p>
        </form>
        
    </div>
</body>
</html>