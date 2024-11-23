<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
</head>
<body>
    <h1 style ="text-align:center">employee</h1>

    <!--Employee Buttons--> 
    <div class ="container">
        <form method ="POST" action="../../controller.php">
            <!--Dependents Button-->
            <button type="submit" name="viewDependentsBtn" >Dependents</button>
            <p></p>
            <!--change contact information button-->
            <button type="submit" name ="viewContactBtn">Change Your Contact Info</button>
            <p></p>
            <!--View Manager information button -->
            <button type="submit" name="viewPaystubsBtn">View Your Paystubs</button>
            <p></p>
            <!-- View Client Information Button -->
            <button type="submit" name="viewClientsBtn">View Your Clients</button>
            <p></p>
            <!-- View Other Employees in Your Department -->
            <button type="submit" name="viewEmpInDeptBtn">View Employee Information</button>
            <p></p>
        </form>
        
    </div>
</body>
</html>