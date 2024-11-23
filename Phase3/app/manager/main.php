<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>
<body>
    <h1  style ="text-align:center">Manager</h1>

    <!--Manager Buttons--> 
    <div class ="container">
        <form method ="POST" action="../../controller.php">
            <!--Paystub Button-->
            <button type="submit" name="paystubBtn" >Paystub</button>
            <p></p>
            <!--Get Employee  contact information button-->
            <button type="submit" name = "ManagerViewEmpBtn">View Employee Information</button>
            <p></p>
            <!--View Client information -->
            <button type="submit" name="viewClientBtn">View Client Information</button>
            <p></p>
            <!--Assign project--> 
            <button type = "submit" name="assignProject">Assign Projects</button>
            <p></p>
        </form>
        
    </div>
</body>
</html>