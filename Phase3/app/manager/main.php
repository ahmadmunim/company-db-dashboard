

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles.css">
    <title>Manager</title>
</head>
<body>
    <h1>Hello Manager!</h1>
    <!--Manager Buttons--> 
    <div class ="container">
        <form class="menu-btn" method ="POST" action="../../controller.php">
            <!--Paystub Button-->
            <button type="submit" name="paystubBtn" >Paystub</button>
            <!--Get Employee  contact information button-->
            <button type="submit" name = "ManagerViewEmpBtn">View Employee Information</button>
            <!--View Client information -->
            <button type="submit" name="viewClientBtn">View Client Information</button>
            <!--Assign project--> 
            <button type = "submit" name="assignProject">Assign Projects</button>
        </form>  
        <div class="right-content">

        </div>
    </div>
</body>
</html>