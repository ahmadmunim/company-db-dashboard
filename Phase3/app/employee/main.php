<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles.css">
    <title>Employee</title>
</head>
<body>
    <h1>Hello employee</h1>

    <!--Employee Buttons--> 
    <div class ="container">
        <form class="menu-btn" method ="POST" action="../../controller.php">
            <!--Dependents Button-->
            <button type="submit" name="viewDependentsBtn" >Dependents</button>
            <!--change contact information button-->
            <button type="submit" name ="viewContactBtn">Change Your Contact Info</button>
            <!--View Manager information button -->
            <button type="submit" name="viewPaystubsBtn">View Your Paystubs</button>
            <!-- View Client Information Button -->
            <button type="submit" name="viewClientsBtn">View Your Clients</button>
            <!-- View Other Employees in Your Department -->
            <button type="submit" name="viewEmpInDeptBtn">View Employee Information</button>
            <!--Logout-->
            <button type="submit" name="logout">Logout</button>
        </form>
        
        <div class="right-content">
            
        </div>
    </div>
    <div class="container">

    </div>
</body>
</html>